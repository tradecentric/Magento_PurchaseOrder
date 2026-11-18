<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Quote\Model\Quote\Payment;

/**
 * Declares data setters for checkout test doubles.
 */
class PaymentDouble extends Payment
{
    /**
     * Set Checks data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setChecks($value)
    {
        return $this->setData('checks', $value);
    }
}
