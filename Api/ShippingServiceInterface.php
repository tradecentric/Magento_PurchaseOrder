<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;

/**
 * Interface ShippingServiceInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface ShippingServiceInterface
{
    /**
     * @param Address $address
     * @param string $shippingCode
     * @return bool
     */
    public function deleteShippingForNonPurchaseOrderEntities(Address $address, string $shippingCode, ?AbstractItem $abstractItem = null): bool;

    /**
     * @param Address $address
     * @param string $shippingCode
     * @param float $price
     * @return mixed
     */
    public function setCustomPriceForShippingMethod(Address $address, string $shippingCode, float $price): bool;
}
