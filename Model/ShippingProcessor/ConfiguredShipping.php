<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\ShippingProcessor;

use Magento\Quote\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingContainerInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingProcessorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class CustomShipping
 * @package Punchout2Go\PurchaseOrder\Model\ShippingProcessor
 */
class ConfiguredShipping implements ShippingProcessorInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ConfiguredShipping constructor.
     * @param Data $data
     */
    public function __construct(Data $data)
    {
        $this->helper = $data;
    }

    /**
     * @param AddressInterface $address
     * @param ShippingContainerInterface $shippingContainer
     * @return mixed|void
     */
    public function addShippingToCart(AddressInterface $address, ShippingContainerInterface $shippingContainer)
    {
        $shippingRate = null;
        foreach ($this->helper->getShippingPolicy($shippingContainer->getStoreId()) as $shippingPolicy) {
            $code = $shippingPolicy['key'] ?? '';
            $shippingRate = $address->getShippingRateByCode($code);
            if ($shippingRate && !$shippingRate->isDeleted()) {
                break;
            }
        }
        if (!$shippingRate) {
           return;
        }
        $address->setShippingMethod($shippingRate->getMethod());
        $name = $shippingRate->getCarrierTitle() ." - ". $shippingRate->getMethodTitle();
        if (null != $shippingRate->getMethodDescription()) {
            $name .= " (". $shippingRate->getMethodDescription() .")";
        }
        $address->setShippingDescription($name);
        $address->setShippingAmount($shippingRate->getPrice());
    }
}
