<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;
use Magento\Quote\Model\Quote\Address;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\Data\CustomerInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\Data\AddressInterfaceFactory;

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
     * @param QuoteInterfaceFactory $quoteFactory
     * @param QuoteItemInterfaceFactory $quoteItemFactory
     * @param CustomerInterfaceFactory $customerFactory
     * @param AddressInterfaceFactory $addressFactory
     */
    public function __construct(
        QuoteInterfaceFactory $quoteFactory,
        QuoteItemInterfaceFactory $quoteItemFactory,
        CustomerInterfaceFactory $customerFactory,
        AddressInterfaceFactory $addressFactory
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->quoteItemFactory = $quoteItemFactory;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return QuoteInterface
     */
    public function build(PunchoutOrderRequestDtoInterface $request) : QuoteInterface
    {
        $details = $request->getDetails();
        /** @var QuoteInterface $quote */
        $quote = $this->quoteFactory->create($details);
        $quote->setStoreCode($request->getStoreCode());
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
        return $quote;
    }
}
