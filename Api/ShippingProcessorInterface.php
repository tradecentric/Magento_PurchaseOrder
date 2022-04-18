<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\AddressInterface;

/**
 * Interface QuoteItemProcessorInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface ShippingProcessorInterface
{
    /**
     * @param AddressInterface $shippingAddress
     * @param \Punchout2Go\PurchaseOrder\Api\ShippingContainerInterface $punchoutShipping
     * @return mixed
     */
    public function addShippingToCart(
        AddressInterface $shippingAddress,
        ShippingContainerInterface $punchoutShipping
    );
}
