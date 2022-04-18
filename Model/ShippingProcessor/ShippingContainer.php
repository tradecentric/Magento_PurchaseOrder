<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\ShippingProcessor;

use Punchout2Go\PurchaseOrder\Api\Data\ShippingInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingContainerInterface;

/**
 * Class ShippingProcessorContainer
 * @package Punchout2Go\PurchaseOrder\Model\ShippingProcessor
 */
class ShippingContainer implements ShippingContainerInterface
{
    /**
     * @var ShippingInterface
     */
    protected $shipping;

    /**
     * @var string
     */
    protected $storeId;

    /**
     * ShippingProcessorContainer constructor.
     * @param ShippingInterface $shipping
     * @param string $storeId
     */
    public function __construct(ShippingInterface $shipping, string $storeId)
    {
        $this->shipping = $shipping;
        $this->storeId = $storeId;
    }

    /**
     * @return ShippingInterface
     */
    public function getShipping(): ShippingInterface
    {
        return $this->shipping;
    }

    /**
     * @return string
     */
    public function getStoreId(): string
    {
        return $this->storeId;
    }
}
