<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\Data\ShippingInterface;

/**
 * Class Shipping
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class Shipping implements ShippingInterface
{

    /**
     * @var float
     */
    protected $shipping = 0.0;

    /**
     * @var string
     */
    protected $shippingTitle = "";

    /**
     * Shipping constructor.
     * @param float $shipping
     * @param string $shipping_title
     */
    public function __construct(
        float $shipping = 0.0,
        string $shipping_title = ''
    ) {
        $this->shipping = $shipping;
        $this->shippingTitle = $shipping_title;
    }

    /**
     * @return float
     */
    public function getShipping(): float
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     */
    public function setShipping(float $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return string
     */
    public function getShippingTitle(): string
    {
        return $this->shippingTitle;
    }

    /**
     * @param string $shippingTitle
     */
    public function setShippingTitle(string $shippingTitle): void
    {
        $this->shippingTitle = $shippingTitle;
    }
}
