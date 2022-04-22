<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Checkout\Api\Data\TotalsInformationInterface;
use Magento\Quote\Model\Quote\Address;
use Punchout2Go\PurchaseOrder\Api\AddressConverterInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Magento\Checkout\Api\Data\ShippingInformationInterfaceFactory;
use Punchout2Go\PurchaseOrder\Helper\Data;

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
     * @param QuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $builder, QuoteInterface $punchoutQuote): void
    {
        $builder->setBillingAddress($this->addressConverter->toQuoteAddress($punchoutQuote->getAddressByType(Address::ADDRESS_TYPE_BILLING)));
    }
}
