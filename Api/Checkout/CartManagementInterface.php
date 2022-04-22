<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Checkout;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface CartManagementInterface
 * @package Punchout2Go\PurchaseOrder\Api\Checkout
 */
interface CartManagementInterface
{
    /**
     * @param CartInterface $cart
     * @param PaymentInterface|null $paymentMethod
     * @return OrderInterface
     */
    public function placeOrderForQuote(CartInterface $cart, PaymentInterface $paymentMethod = null): OrderInterface;
}
