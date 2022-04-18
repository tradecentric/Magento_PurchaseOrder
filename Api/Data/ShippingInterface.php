<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * Interface ShippingInterface
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface ShippingInterface
{
    /**
     * @return float
     */
    public function getShipping(): float;

    /**
     * @param float $shipping
     */
    public function setShipping(float $shipping): void;
    /**
     * @return string
     */
    public function getShippingTitle(): string;

    /**
     * @param string $shippingTitle
     */
    public function setShippingTitle(string $shippingTitle): void;
}
