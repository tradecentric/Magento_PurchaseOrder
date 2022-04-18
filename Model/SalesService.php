<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote\Address;
use Magento\Sales\Api\Data\OrderInterface;
use Punchout2Go\PurchaseOrder\Api\AddressConverterInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Quote\Api\Data\CartInterfaceFactory;
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
     * @var CartInterfaceFactory
     */
    protected $quoteFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param CartManagementInterface $cartManagement
     * @param StoreRepositoryInterface $storeRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param CartRepositoryInterface $quoteRepository
     * @param CartInterfaceFactory $quoteFactory
     * @param AddressConverterInterface $addressConverter
     * @param Data $helper
     */
    public function __construct(
        CartManagementInterface $cartManagement,
        StoreRepositoryInterface $storeRepository,
        CustomerRepositoryInterface $customerRepository,
        CartRepositoryInterface $quoteRepository,
        CartInterfaceFactory $quoteFactory,
        AddressConverterInterface $addressConverter,
        Data $helper
    ) {
        $this->cartManagement = $cartManagement;
        $this->storeRepository = $storeRepository;
        $this->customerRepository = $customerRepository;
        $this->quoteRepository = $quoteRepository;
        $this->quoteFactory = $quoteFactory;
        $this->addressConverter = $addressConverter;
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
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Store\Model\StoreIsInactiveException
     */
    public function createQuote(QuoteInterface $punchoutQuote): CartInterface
    {
        $store = $this->getStore($punchoutQuote->getStoreCode());
        $customer = $this->getCustomer($punchoutQuote->getCustomer()->getEmail(), $store->getWebsiteId());
        $quote = $this->getQuote($punchoutQuote->getMagentoQuoteId(), $store->getId());
        if (!$customer || !$customer->getId()) {
            $quote->setCustomerIsGuest(1);
        }
        if (!$this->helper->isAllowedReorder($store->getId())) {

        }
        $quote->setShippingAddress(
            $this->addressConverter->toOrderAddress($punchoutQuote->getAddressByType(Address::ADDRESS_TYPE_SHIPPING))
        );
        $quote->setBillingAddress(
            $this->addressConverter->toOrderAddress($punchoutQuote->getAddressByType(Address::ADDRESS_TYPE_BILLING))
        );
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
