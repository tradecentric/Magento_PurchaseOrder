<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * Interface ShippingInterface
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface ShippingInterface
{
    /**
     * @return string
     */
    public function getShippingAmount(): string;

    /**
     * @param string $shipping
     */
    public function setShippingAmount(string $shipping): void;
    /**
     * @return string
     */
    public function getShippingTitle(): string;

    /**
     * @param string $shippingTitle
     */
    public function setShippingTitle(string $shippingTitle): void;

    /**
     * @return string
     */
    public function getShippingMethod(): string;

    /**
     * @param string $shippingMethod
     */
    public function setShippingMethod(string $shippingMethod): void;
}
