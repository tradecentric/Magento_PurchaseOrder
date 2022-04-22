<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Shipping;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\Rate;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ShippingInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingRateSelectorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ShippingPolicyRate
 * @package Punchout2Go\PurchaseOrder\Model\Shipping
 */
class ShippingPolicyRate implements ShippingRateSelectorInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param AddressInterface $address
     * @param null $storeId
     * @return Rate|null
     */
    public function getRateForAddress(AddressInterface $address, $storeId = null): ?Rate
    {
        $result = null;
        foreach ($this->helper->getShippingPolicy($storeId) as $shippingPolicy) {
            $rate = $address->getShippingRateByCode($shippingPolicy['shipping_policy']);
            if ($rate && !$rate->isDeleted()) {
                $result = $rate;
                break;
            }
        }
        return $result;
    }
}
