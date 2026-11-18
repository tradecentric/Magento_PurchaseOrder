<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Quote\Model\Quote\Address;

/**
 * Declares data setters for checkout test doubles.
 */
class AddressDouble extends Address
{
    /**
     * Set LimitCarrier data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setLimitCarrier($value)
    {
        return $this->setData('limit_carrier', $value);
    }

    /**
     * Set CollectShippingRates data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setCollectShippingRates($value)
    {
        return $this->setData('collect_shipping_rates', $value);
    }

    /**
     * Set PaymentMethod data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setData('payment_method', $value);
    }
}
