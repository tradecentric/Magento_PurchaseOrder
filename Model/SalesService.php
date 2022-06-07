<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Event\ManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\TotalsInformationManagementInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\PaymentInformationManagementInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\CartManagementInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Magento\Quote\Api\Data\CartInterfaceFactory;
use Punchout2Go\PurchaseOrder\Logger\StoreLoggerInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class SalesService
 * @package Punchout2Go\PurchaseOrder\Model
 */
class SalesService implements SalesServiceInterface
{
    /**
     * @var CartManagementInterface
     */
    protected $cartManagement;

    /**
     * @var QuoteBuildContainerInterfaceFactory
     */
    protected $buildContainerFactory;

    /**
     * @var TotalsInformationManagementInterface
     */
    protected $shippingInformationManagement;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var PaymentInformationManagementInterface
     */
    protected $paymentInformationManagement;

    /**
     * @var CartInterfaceFactory
     */
    protected $quoteFactory;

    /**
     * @var QuoteElementHandlerInterface
     */
    protected $quoteBuilder;

    /**
     * @var ProductAvailabilityChecker
     */
    protected $productAvailabilityChecker;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var ReorderProvider
     */
    protected $reorderProvider;

    /**
     * @var StoreLoggerInterface
     */
    protected $logger;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param CartManagementInterface $cartManagement
     * @param CartRepositoryInterface $quoteRepository
     * @param OrderRepositoryInterface $orderRepository
     * @param CartInterfaceFactory $quoteFactory
     * @param TotalsInformationManagementInterface $shippingInformationManagement
     * @param PaymentInformationManagementInterface $paymentInformationManagement
     * @param QuoteElementHandlerInterface $quoteBuilder
     * @param QuoteBuildContainerInterfaceFactory $buildContainerFactory
     * @param ProductAvailabilityChecker $productAvailabilityChecker
     * @param ManagerInterface $eventManager
     * @param StoreLoggerInterface $logger
     * @param ReorderHandler $reorderHandler
     * @param Data $helper
     */
    public function __construct(
        CartManagementInterface $cartManagement,
        CartRepositoryInterface $quoteRepository,
        OrderRepositoryInterface $orderRepository,
        CartInterfaceFactory $quoteFactory,
        TotalsInformationManagementInterface $shippingInformationManagement,
        PaymentInformationManagementInterface $paymentInformationManagement,
        QuoteElementHandlerInterface $quoteBuilder,
        QuoteBuildContainerInterfaceFactory $buildContainerFactory,
        ProductAvailabilityChecker $productAvailabilityChecker,
        ManagerInterface $eventManager,
        StoreLoggerInterface $logger,
        ReorderProvider $reorderProvider,
        Data $helper
    ) {
        $this->cartManagement = $cartManagement;
        $this->buildContainerFactory = $buildContainerFactory;
        $this->shippingInformationManagement = $shippingInformationManagement;
        $this->quoteRepository = $quoteRepository;
        $this->orderRepository = $orderRepository;
        $this->quoteFactory = $quoteFactory;
        $this->paymentInformationManagement = $paymentInformationManagement;
        $this->quoteBuilder = $quoteBuilder;
        $this->productAvailabilityChecker = $productAvailabilityChecker;
        $this->eventManager = $eventManager;
        $this->reorderProvider = $reorderProvider;
        $this->logger = $logger;
        $this->helper = $helper;
    }

    /**
     * @param PunchoutQuoteInterface $punchoutQuote
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createOrder(PunchoutQuoteInterface $punchoutQuote): int
    {
        $quote = $this->createQuote($punchoutQuote);
        $this->logger->info("Place punchout order for quote " . $quote->getId());
        $order = $this->cartManagement->placeOrderForQuote($quote);
        if ($this->applyTaxesToOrder($order, $punchoutQuote->getTax())) {
            $this->logger->info("Apply taxes for order " . $order->getIncrementId());
            $this->orderRepository->save($order);
        }

        return (int) $order->getEntityId();
    }

    /**
     * @param OrderInterface $order
     * @param string $taxAmount
     * @return bool
     */
    protected function applyTaxesToOrder(OrderInterface $order, string $taxAmount): bool
    {
        if ((float) $taxAmount) {
            return false;
        }
        if (!$this->helper->isAllowedTaxes($order->getStoreId())) {
            return false;
        }
        $this->logger->info("Save order taxes");
        $items = $order->getAllItems();
        foreach ($items as $item) {
            $item->setTaxAmount(0);
            $item->setTaxPercent(0);
        }

        $order->setTaxAmount($taxAmount);
        $order->setBaseTaxAmount($taxAmount);
        $order->setGrandTotal($order->getSubtotal() + $order->getShippingAmount() + $order->getTaxAmount());
        $order->setBaseGrandTotal($order->getBaseSubtotal() + $order->getBaseShippingAmount() + $order->getBaseTaxAmount());
        return true;
    }

    /**
     * @param PunchoutQuoteInterface $punchoutQuote
     * @return CartInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createQuote(PunchoutQuoteInterface $punchoutQuote): CartInterface
    {
        $this->logger->info("Create punchout quote " . $punchoutQuote->getMagentoQuoteId());
        $quote = $this->loadQuote($punchoutQuote->getMagentoQuoteId(), $punchoutQuote->getStoreId());
        /** @var \Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface $quoteBuilderContainer */
        $quoteBuilderContainer = $this->buildContainerFactory->create();
        $this->quoteBuilder->handle($quoteBuilderContainer, $punchoutQuote);
        if ($transferQuote = $quoteBuilderContainer->getQuote()) {
            $quote->addData($transferQuote->getData());
        }
        if ($quoteBuilderContainer->getCustomer()) {
            $this->logger->info("Set punchout customer, quote " . $punchoutQuote->getMagentoQuoteId());
            $quote->setCustomer($quoteBuilderContainer->getCustomer());
        } else {
            $this->logger->info("Set punchout customer in guest, quote " . $punchoutQuote->getMagentoQuoteId());
            $quote->setCustomerIsGuest(1);
        }
        $this->prepareQuoteItems($quote, $quoteBuilderContainer->getItems());
        $quote->setTotalsCollectedFlag(false)->collectTotals();
        if ($shipping = $quoteBuilderContainer->getShippingTotals()) {
            $this->logger->info("Set quote shipping, quote " . $punchoutQuote->getMagentoQuoteId());
            $this->shippingInformationManagement->calculate($quote, $shipping);
        }
        if ($payment = $quoteBuilderContainer->getPayment()) {
            $this->logger->info("Set quote payment, quote " . $punchoutQuote->getMagentoQuoteId());
            $this->paymentInformationManagement->savePaymentInformation($quote, $payment, $quoteBuilderContainer->getBillingAddress());
        }
        $this->eventManager->dispatch('purchase_order_quote_save_before', ['quote' => $quote]);
        $this->quoteRepository->save($quote);
        return $quote;
    }

    /**
     * @param int $quoteId
     * @param string $storeId
     * @return CartInterface|\Magento\Quote\Model\Quote
     */
    protected function loadQuote(int $quoteId, string $storeId)
    {
        try {
            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $this->quoteRepository->get($quoteId, [$storeId]);
        } catch (NoSuchEntityException $e) {
            $quote = $this->quoteFactory->create()
                ->setStoreId($storeId);
            $this->quoteRepository->save($quote);
        }
        $quote->setIsActive(true)
            ->setIgnoreOldQty(true)
            ->setIsSuperMode(true);
        return $quote;
    }

    /**
     * @param CartInterface $quote
     * @param array $items
     * @throws LocalizedException
     */
    protected function prepareQuoteItems(CartInterface $quote, array $items)
    {
        foreach ($quote->getAllVisibleItems() as $item) {
            if ($item->getItemId() && !isset($items[$item->getItemId()])) {
                $quote->removeItem($item->getItemId());
            }
        }
        $quoteIds = [];
        foreach ($items as $item) {
            $quoteItem = $this->addItemToQuote($quote, $item);
            $quoteIds[] = $quoteItem->getItemId();
        }
        $quoteIds = array_filter($quoteIds);
        if (!$quoteIds || $this->helper->isAllowedReorder($quote->getStoreId())) {
            return;
        }
        if ($alreadyPlaced = $this->reorderProvider->getAlreadyOrderedItems($quoteIds)) {
            $itemSku = [];
            foreach ($alreadyPlaced as $itemId) {
                $itemSku[] = $quote->getItemById($itemId)->getSku();
            }
            throw new LocalizedException(__("The following item(s) were already ordered %1", implode(", ", $itemSku)));
        }
    }

    /**
     * @param CartInterface $quote
     * @param CartItemInterface $item
     * @return bool|\Magento\Quote\Model\Quote\Item|string|null
     * @throws LocalizedException
     */
    protected function addItemToQuote(CartInterface $quote, CartItemInterface $item)
    {
        $quoteItem = $quote->getItemById($item->getItemId());
        $product = $quoteItem ? $quoteItem->getProduct() : $item->getProduct();
        $this->logger->info("Set punchout quote item " . $item->getItemId());
        if (!$this->productAvailabilityChecker->isProductAvailabile($product, $quote->getStoreId())) {
            $this->logger->info("Product " . $product->getSku() . " is not available");
            throw new LocalizedException(__("Product is not available : %1 %2", $product->getName(), $product->getSku()));
        }
        if (!$quoteItem) {
            if (!$this->helper->isItemsAvailabilityCheck($quote->getStoreId())) {
                $product->setSkipCheckRequiredOption(true);
            }
            $quoteItem = $quote->addProduct($product, $item->getQty());
            $item->unsItemId();
        }
        if (!$this->helper->isAllowedQtyEdit($quote->getStoreId())) {
            $item->unsQty();
        }
        if (!$this->helper->isAllowedUnitPriceEdit($quote->getStoreId())) {
            $item->unsCustomPrice();
            $item->unsOriginalCustomPrice();
        }
        $quoteItem->addData($item->getData());
        $quoteItem->isDeleted(false);
        $quoteItem->checkData();
        return $quoteItem;
    }
}
