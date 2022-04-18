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
class MinPriceShipping implements ShippingProcessorInterface
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
        /** @var \Magento\Quote\Model\Quote\Address\Rate $minPriceRate */
        $minPriceRate = $this->getMinPriceRate($address->getAllShippingRates());
        $address->setShippingMethod($minPriceRate->getMethod());
        $name = $minPriceRate->getCarrierTitle() ." - ". $minPriceRate->getMethodTitle();
        if (null != $minPriceRate->getMethodDescription()) {
            $name .= " (". $minPriceRate->getMethodDescription() .")";
        }
        $address->setShippingDescription($name);
        $address->setShippingAmount($minPriceRate->getPrice());
    }

    /**
     * @param array $rates
     * @return false|mixed
     */
    protected function getMinPriceRate(array $rates)
    {
        $minPrice = min(array_column($rates, 'price'));
        $rate = array_filter($rates, function ($rate) use ($minPrice) {
            return $rate->getPrice() === $minPrice;
        });
        return current($rate);
    }
}
