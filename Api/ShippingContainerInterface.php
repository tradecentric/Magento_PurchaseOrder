<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\Data\ShippingInterface;

/**
 * Interface QuoteItemProcessorInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface ShippingContainerInterface
{
    /**
     * @return ShippingInterface
     */
    public function getShipping(): ShippingInterface;

    /**
     * @return string
     */
    public function getStoreId(): string;
}
