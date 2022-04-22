<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\Rate;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ShippingInterface;

/**
 * Interface QuoteItemProcessorInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface ShippingRateSelectorInterface
{
    /**
     * @param AddressInterface $address
     * @param null $store
     * @return Rate|null
     */
    public function getRateForAddress(AddressInterface $address, $store = null): ?Rate;
}
