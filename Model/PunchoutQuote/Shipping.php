<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\ShippingInterface;

/**
 * Class Shipping
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class Shipping implements ShippingInterface
{
    /**
     * @var string
     */
    protected $shippingMethod;
    /**
     * @var string
     */
    protected $shippingAmount = '';

    /**
     * @var string
     */
    protected $shippingTitle = "";

    /**
     * @param string $shipping_method
     * @param string $shipping
     * @param string $shipping_title
     */
    public function __construct(
        string $shipping_method = '',
        string $shipping = '',
        string $shipping_title = ''
    ) {
        $this->shippingMethod = $shipping_method;
        $this->shippingAmount = $shipping;
        $this->shippingTitle = $shipping_title;
    }

    /**
     * @return string
     */
    public function getShippingMethod(): string
    {
        return $this->shippingMethod;
    }

    /**
     * @param string $shippingMethod
     */
    public function setShippingMethod(string $shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return string
     */
    public function getShippingAmount(): string
    {
        return $this->shippingAmount;
    }

    /**
     *
     * @param string $shipping
     */
    public function setShippingAmount(string $shipping): void
    {
        $this->shippingAmount = $shipping;
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
