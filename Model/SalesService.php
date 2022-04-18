<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote\Address;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Punchout2Go\PurchaseOrder\Api\AddressConverterInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;
use Magento\Quote\Model\Quote as MagentoQuote;
use Punchout2Go\PurchaseOrder\Api\QuoteItemProcessorInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Quote\Api\Data\CartInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\ShippingProcessorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class SalesService implements SalesServiceInterface
{
    /**
     * @var CartManagementInterface
     */
    protected $cartManagement;

    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var AddressConverterInterface
     */
    protected $addressConverter;

    /**
     * @var ShippingProcessorInterface
     */
    protected $shippingProcessor;

    /**
     * @var QuoteItemProcessorInterface
     */
    protected $quoteItemProcessor;

    /**
     * @var CartInterfaceFactory
     */
    protected $quoteFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * SalesService constructor.
     * @param CartManagementInterface $cartManagement
     * @param StoreRepositoryInterface $storeRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param CartRepositoryInterface $quoteRepository
     * @param CartInterfaceFactory $quoteFactory
     * @param QuoteItemProcessorInterface $quoteItemProcessor
     * @param ShippingProcessorInterface $shippingProcessor
     * @param AddressConverterInterface $addressConverter
     * @param StoreManagerInterface $storeManager
     * @param Data $helper
     */
    public function __construct(
        CartManagementInterface $cartManagement,
        StoreRepositoryInterface $storeRepository,
        CustomerRepositoryInterface $customerRepository,
        CartRepositoryInterface $quoteRepository,
        CartInterfaceFactory $quoteFactory,
        QuoteItemProcessorInterface $quoteItemProcessor,
        ShippingProcessorInterface $shippingProcessor,
        AddressConverterInterface $addressConverter,
        StoreManagerInterface $storeManager,
        Data $helper
    ) {
        $this->cartManagement = $cartManagement;
        $this->storeRepository = $storeRepository;
        $this->customerRepository = $customerRepository;
        $this->quoteRepository = $quoteRepository;
        $this->quoteFactory = $quoteFactory;
        $this->addressConverter = $addressConverter;
        $this->quoteItemProcessor = $quoteItemProcessor;
        $this->shippingProcessor = $shippingProcessor;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    /**
     * @param QuoteInterface $punchoutQuote
     * @return OrderInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function createOrder(QuoteInterface $punchoutQuote): OrderInterface
    {
        $quote = $this->createQuote($punchoutQuote);
        return $this->cartManagement->placeOrder($quote->getId());
    }

    /**
     * @param QuoteInterface $punchoutQuote
     * @return CartInterface
     * @throws NoSuchEntityException
     * @throws \Magento\Store\Model\StoreIsInactiveException
     */
    public function createQuote(QuoteInterface $punchoutQuote): CartInterface
    {
        $store = $this->getStore($punchoutQuote->getStoreCode());
        $this->storeManager->setCurrentStore($store);
        $quote = $this->getQuote($punchoutQuote->getMagentoQuoteId(), $store->getId());
        $this->addCustomerQuote($quote, $punchoutQuote);
        if (!$this->helper->isAllowedReorder($store->getId())) {

        }
        $this->addAddressesToQuote($quote, $punchoutQuote);
        $this->addItemsToQuote($quote, $punchoutQuote);
        $this->addShippingToQuote($quote, $punchoutQuote);

    }

    /**
     * @param CartInterface $quote
     * @param QuoteInterface $punchoutQuote
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Store\Model\StoreIsInactiveException
     */
    protected function addCustomerQuote(CartInterface $quote, QuoteInterface $punchoutQuote)
    {
        $store = $this->getStore($punchoutQuote->getStoreCode());
        $customer = $this->getCustomer($punchoutQuote->getCustomer()->getEmail(), $store->getWebsiteId());
        if (!$customer || !$customer->getId()) {
            $quote->setCustomerIsGuest(1);
        } else {
            $quote->setCustomer($customer);
        }
    }

    /**
     * @param CartInterface $quote
     * @param QuoteInterface $punchoutQuote
     */
    protected function addAddressesToQuote(CartInterface $quote, QuoteInterface $punchoutQuote)
    {
        $quote->setShippingAddress(
            $this->addressConverter->toQuoteAddress($punchoutQuote->getAddressByType(Address::ADDRESS_TYPE_SHIPPING))
        );
        $quote->setBillingAddress(
            $this->addressConverter->toQuoteAddress($punchoutQuote->getAddressByType(Address::ADDRESS_TYPE_BILLING))
        );
    }

    /**
     * @param CartInterface $quote
     * @param QuoteInterface $punchoutQuote
     */
    protected function addItemsToQuote(CartInterface $quote, QuoteInterface $punchoutQuote)
    {
        $addedItems = [];
        foreach ($punchoutQuote->getItems() as $item) {
            $item = $this->quoteItemProcessor->addPunchoutQuoteItemToCart($quote, $item);
            $addedItems[] = $item->getItemId();
        }
        foreach ($quote->getAllVisibleItems() as $quoteItem) {
            if (!in_array($quoteItem->getItemId(), $addedItems)) {
                $quote->removeItem($quoteItem->getItemId());
            }
        }
    }

    /**
     * @param CartInterface $quote
     * @param QuoteInterface $punchoutQuote
     */
    protected function addShippingToQuote(CartInterface $quote, QuoteInterface $punchoutQuote)
    {
        $quote->getShippingAddress()->setCollectShippingRates(true);
        $quote->collectRates();
        $shippingRates = $quote->getShippingAddress()->getAllShippingRates();
        if (count($shippingRates) == 0) {
            return false;
        }
        $this->shippingProcessor->addShippingToCart($quote, $punchoutQuote->getShipping());
        $shippingRate = null;

        if ($this->helper->isAllowApplyShipping($quote->getStoreId())) {
            $shippingRate = $punchoutQuote->getShippingTitle();
            $shippingPrice = $punchoutQuote->getShipping();
        }
        if (!$shippingRate) {
            $shippingRate->getCheapestShippingRate($shippingRates);
        }
    }

    /**
     * @param string $storeCode
     * @return \Magento\Store\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Store\Model\StoreIsInactiveException
     */
    protected function getStore(string $storeCode)
    {
        return $this->storeRepository->getActiveStoreByCode($storeCode);
    }

    /**
     * @param string $email
     * @param int $websiteId
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getCustomer(string $email, int $websiteId)
    {
        try {
            return $this->customerRepository->get($email, $websiteId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @param int $quoteId
     * @param $storeId
     * @return CartInterface
     */
    protected function getQuote(int $quoteId, $storeId)
    {
        try {
            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $this->quoteRepository->get($quoteId, [$storeId]);
            $quote->setIsActive(false);
            $quote->setDirectLoad(true);
            $quote->setIgnoreOldQty(true);
            $quote->setIsSuperMode(true);
        } catch (NoSuchEntityException $e) {
            $quote = $this->quoteFactory->create()
                ->setStoreId($storeId);
        }
        if ($quote->getItemsCount() > 0 && $quote->getDirectLoad()) {
            $items = $quote->getAllVisibleItems();
            /** @var \Magento\Quote\Model\Quote\Item $item */
            foreach ($items AS $item) {
                $item->setLineNumber(null);
            }
        }
        return $quote;
    }
}
