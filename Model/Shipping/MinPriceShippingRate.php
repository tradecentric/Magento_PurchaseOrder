<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Shipping;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\Rate;
use Punchout2Go\PurchaseOrder\Api\ShippingRateSelectorInterface;

/**
 * Class MinPriceShippingRate
 * @package Punchout2Go\PurchaseOrder\Model\Shipping
 */
class MinPriceShippingRate implements ShippingRateSelectorInterface
{
    /**
     * @param AddressInterface $address
     * @param null $storeId
     * @return Rate
     */
    public function getRateForAddress(AddressInterface $address, $storeId = null): ? Rate
    {
        $rates = $address->getAllShippingRates();
        $prices = array_map(function($rate) {
            return $rate->getPrice();
        }, $rates);
        $minPrice = min(array_diff($prices, [null]));
        $rate = array_filter($rates, function ($rate) use ($minPrice) {
            return $rate->getPrice() === $minPrice;
        });
        return current($rate);
    }
}
