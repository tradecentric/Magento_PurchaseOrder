<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Checkout;

use Magento\Framework\Exception\State\InvalidTransitionException;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\PaymentInformationManagementInterface;

/**
 * Class PaymentInformationManagement
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PaymentInformationManagement implements PaymentInformationManagementInterface
{
    /**
     * @param CartInterface $quote
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @return mixed|void
     */
    public function savePaymentInformation(
        CartInterface $quote,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        if ($billingAddress) {
            $customerId = $quote->getBillingAddress()->getCustomerId();
            if (!$billingAddress->getCustomerId() && $customerId) {
                //It's necessary to verify the price rules with the customer data
                $billingAddress->setCustomerId($customerId);
            }
            //$quote->removeAddress($quote->getBillingAddress()->getId());
            $quote->setBillingAddress($billingAddress);
            $quote->setDataChanges(true);
            $shippingAddress = $quote->getShippingAddress();
            if ($shippingAddress && $shippingAddress->getShippingMethod()) {
                $shippingRate = $shippingAddress->getShippingRateByCode($shippingAddress->getShippingMethod());
                if ($shippingRate) {
                    $shippingAddress->setLimitCarrier($shippingRate->getCarrier());
                }
            }
        }
        $this->set($quote, $paymentMethod);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function set(CartInterface $quote, PaymentInterface $method)
    {
        $quote->setTotalsCollectedFlag(false);
        $method->setChecks([
            \Magento\Payment\Model\MethodInterface::CHECK_USE_CHECKOUT,
            \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_COUNTRY,
            \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_CURRENCY,
            \Magento\Payment\Model\MethodInterface::CHECK_ORDER_TOTAL_MIN_MAX,
        ]);

        if ($quote->isVirtual()) {
            $address = $quote->getBillingAddress();
        } else {
            $address = $quote->getShippingAddress();
            // check if shipping address is set
            if ($address->getCountryId() === null) {
                throw new InvalidTransitionException(
                    __('The shipping address is missing. Set the address and try again.')
                );
            }
            $address->setCollectShippingRates(true);
        }

        $payment = $quote->getPayment();
        $payment->importData($method->getData());
        $address->setPaymentMethod($payment->getMethod());

        return $quote;
    }
}
