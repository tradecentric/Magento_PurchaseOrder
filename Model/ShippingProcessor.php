<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Quote\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\Data\ShippingInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingContainerInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingProcessorInterface;

/**
 * Class ShippingProcessor
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ShippingProcessor implements ShippingProcessorInterface
{
    /**
     * @var array
     */
    protected $shippingProcessors = [];

    /**
     * ShippingProcessor constructor.
     * @param array $shippingProcessors
     */
    public function __construct(array $shippingProcessors = [])
    {
        $this->shippingProcessors = $shippingProcessors;
    }

    /**
     * @param AddressInterface $address
     * @param ShippingContainerInterface $shippingContainer
     * @return mixed|void
     */
    public function addShippingToCart(AddressInterface $address, ShippingContainerInterface $shippingContainer)
    {
        foreach ($this->shippingProcessors as $shippingProcessor) {
            $this->process($address, $shippingContainer);
        }
    }

    /**
     * @param ShippingProcessorInterface $processor
     * @param AddressInterface $address
     * @param ShippingInterface $punchoutShipping
     * @return mixed
     */
    protected function process(
        ShippingProcessorInterface $processor,
        AddressInterface $address,
        ShippingInterface $punchoutShipping
    ) {
        return $processor->addShippingToCart($address, $punchoutShipping);
    }
}
