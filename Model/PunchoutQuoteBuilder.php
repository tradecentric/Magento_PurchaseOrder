<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Quote\Model\Quote\Address;
use Magento\Store\Model\StoreManagerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PaymentInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ShippingInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterfaceFactory;

/**
 * @package
 */
class PunchoutQuoteBuilder
{
    /**
     * @var QuoteInterfaceFactory
     */
    protected $quoteFactory;

    /**
     * @var QuoteItemInterfaceFactory
     */
    protected $quoteItemFactory;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerFactory;

    /**
     * @var AddressInterfaceFactory
     */
    protected $addressFactory;

    /**
     * @var ShippingInterfaceFactory
     */
    protected $shippingFactory;

    /**
     * @var PaymentInterfaceFactory
     */
    protected $paymentFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param QuoteInterfaceFactory $quoteFactory
     * @param QuoteItemInterfaceFactory $quoteItemFactory
     * @param CustomerInterfaceFactory $customerFactory
     * @param AddressInterfaceFactory $addressFactory
     * @param ShippingInterfaceFactory $shippingFactory
     * @param PaymentInterfaceFactory $paymentFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        QuoteInterfaceFactory $quoteFactory,
        QuoteItemInterfaceFactory $quoteItemFactory,
        CustomerInterfaceFactory $customerFactory,
        AddressInterfaceFactory $addressFactory,
        ShippingInterfaceFactory $shippingFactory,
        PaymentInterfaceFactory $paymentFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->quoteItemFactory = $quoteItemFactory;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
        $this->shippingFactory = $shippingFactory;
        $this->paymentFactory = $paymentFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return QuoteInterface
     */
    public function build(PunchoutOrderRequestDtoInterface $request) : QuoteInterface
    {
        $details = $request->getDetails();
        $header = $request->getHeader();
        /** @var QuoteInterface $quote */
        $quote = $this->quoteFactory->create($details);
        $quote->setStoreCode($request->getStoreCode());
        $quote->setStoreId((string) $this->storeManager->getStore($quote->getStoreCode())->getId());
        $quote->setOrderRequestId($header['order_request_id'] ?? '');
        $customer = $this->customerFactory->create($details['contact'] ?? []);
        $quote->setCustomer($customer);
        /** @var AddressInterface $billingAddress */
        $billingAddress = $this->addressFactory->create($details['bill_to'] ?? []);
        $billingAddress->setType(Address::ADDRESS_TYPE_BILLING);
        $quote->addAddress($billingAddress);
        /** @var AddressInterface $billingAddress */
        $shippingAddress = $this->addressFactory->create($details['ship_to'] ?? []);
        $shippingAddress->setType(Address::ADDRESS_TYPE_SHIPPING);
        $quote->addAddress($shippingAddress);
        foreach ($request->getItems() as $requestItem) {
            $quote->addItem($this->quoteItemFactory->create($requestItem));
        }
        $quote->setShipping(
            $this->shippingFactory->create(
                [
                    'shipping' => $details['shipping'] ?? '',
                    'shipping_method' => $details['shipping_code'] ?? '',
                    'shipping_title' => $details['shipping_title'] ?? ''
                ]
            )
        );
        $quote->setPayment($this->paymentFactory->create($header));
        return $quote;
    }
}
