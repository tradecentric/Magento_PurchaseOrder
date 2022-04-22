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
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Magento\Quote\Api\Data\CartInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\ShippingRateSelectorInterface;
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
     * @param ShippingRateSelectorInterface $shippingRateSelector
     * @param ManagerInterface $eventManager
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
        $this->helper = $helper;
    }

    /**
     * @param QuoteInterface $punchoutQuote
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createOrder(QuoteInterface $punchoutQuote): int
    {
        $quote = $this->createQuote($punchoutQuote);
        $order = $this->cartManagement->placeOrderForQuote($quote);
        if ($this->applyTaxesToOrder($order, $punchoutQuote->getTax())) {
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
     * @param QuoteInterface $punchoutQuote
     * @return CartInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createQuote(QuoteInterface $punchoutQuote): CartInterface
    {
        $quote = $this->loadQuote($punchoutQuote->getMagentoQuoteId(), $punchoutQuote->getStoreId());
        /** @var \Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface $quoteBuilderContainer */
        $quoteBuilderContainer = $this->buildContainerFactory->create();
        $this->quoteBuilder->handle($quoteBuilderContainer, $punchoutQuote);
        if ($transferQuote = $quoteBuilderContainer->getQuote()) {
            $quote->addData($transferQuote->getData());
        }
        if ($quoteBuilderContainer->getCustomer()) {
            $quote->setCustomer($quoteBuilderContainer->getCustomer());
        } else {
            $quote->setCustomerIsGuest(1);
        }
        $this->prepareQuoteItems($quote, $quoteBuilderContainer->getItems());
        $quote->setTotalsCollectedFlag(false)->collectTotals();
        if ($shipping = $quoteBuilderContainer->getShippingTotals()) {
            $this->shippingInformationManagement->calculate($quote, $shipping);
        }
        if ($payment = $quoteBuilderContainer->getPayment()) {
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
        foreach ($items as $item) {
            $this->addItemToQuote($quote, $item);
        }
    }

    /**
     * @param CartInterface $quote
     * @param CartItemInterface $item
     * @throws LocalizedException
     */
    protected function addItemToQuote(CartInterface $quote, CartItemInterface $item)
    {
        $quoteItem = $quote->getItemById($item->getItemId());
        $product = $quoteItem ? $quoteItem->getProduct() : $item->getProduct();
        if (!$this->productAvailabilityChecker->isProductAvailabile($product, $quote->getStoreId())) {
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
    }
}
