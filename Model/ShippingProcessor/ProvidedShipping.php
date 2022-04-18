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
class ProvidedShipping implements ShippingProcessorInterface
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
        if (!$this->helper->isAllowProvidedShipping($shippingContainer->getStoreId())) {
            return;
        }
        $address->setShippingDescription($shippingContainer->getShipping()->getShippingTitle());
        $address->setShippingAmount($shippingContainer->getShipping()->getShipping());
    }
}
