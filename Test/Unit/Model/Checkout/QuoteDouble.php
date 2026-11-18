<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Quote\Model\Quote;

/**
 * Declares data setters for checkout test doubles.
 */
class QuoteDouble extends Quote
{
    /**
     * Set CustomerEmail data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setCustomerEmail($value)
    {
        return $this->setData('customer_email', $value);
    }

    /**
     * Set CustomerGroupId data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setCustomerGroupId($value)
    {
        return $this->setData('customer_group_id', $value);
    }

    /**
     * Set CustomerId data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setCustomerId($value)
    {
        return $this->setData('customer_id', $value);
    }

    /**
     * Set TotalsCollectedFlag data.
     *
     * @param mixed $value
     * @return $this
     */
    public function setTotalsCollectedFlag($value)
    {
        return $this->setData('totals_collected_flag', $value);
    }
}
