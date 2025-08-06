<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Checkout;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\AddressInterface;

/**
 * Class PaymentInformationManagementInterface
 * @package Punchout2Go\PurchaseOrder\Api\Checkout
 */
interface PaymentInformationManagementInterface
{
    /**
     * @param CartInterface $quote
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @return mixed
     */
    public function savePaymentInformation(
        CartInterface $quote,
        PaymentInterface $paymentMethod,
        ?AddressInterface $billingAddress = null
    );

    /**
     * @param CartInterface $quote
     * @param PaymentInterface $method
     * @return mixed
     */
    public function set(
        CartInterface $quote,
        PaymentInterface $method
    );
}
