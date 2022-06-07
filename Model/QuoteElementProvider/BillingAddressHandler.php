<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Quote\Model\Quote\Address;
use Punchout2Go\PurchaseOrder\Api\AddressConverterInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;

/**
 * Class ShippingHandler
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class BillingAddressHandler implements QuoteElementHandlerInterface
{
    /**
     * @var AddressConverterInterface
     */
    protected $addressConverter;

    /**
     * ram TotalsInformationInterfaceFactory $factory
     */
    public function __construct(
        AddressConverterInterface $addressConverter
    ) {
        $this->addressConverter = $addressConverter;
    }

    /**
     * @param QuoteBuildContainerInterface $builder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $builder, PunchoutQuoteInterface $punchoutQuote): void
    {
        $billingAddress = $this->addressConverter->toQuoteAddress($punchoutQuote->getBillTo());
        $billingAddress->setAddressType(Address::ADDRESS_TYPE_BILLING);
        $builder->setBillingAddress($billingAddress);
    }
}
