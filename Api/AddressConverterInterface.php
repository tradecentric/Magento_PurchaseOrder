<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface as PunchoutAddressInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface AddressConverterInterface
{
    /**
     * @param PunchoutAddressInterface $address
     * @return AddressInterface
     */
    public function toQuoteAddress(PunchoutAddressInterface $address): AddressInterface;
}
