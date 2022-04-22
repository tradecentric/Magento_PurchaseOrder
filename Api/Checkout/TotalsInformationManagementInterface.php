<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Checkout;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Checkout\Api\Data\TotalsInformationInterface;

/**
 * Interface TotalsInformationManagementInterface
 * @package Punchout2Go\PurchaseOrder\Api\Checkout
 */
interface TotalsInformationManagementInterface
{
    /**
     * @param CartInterface $quote
     * @param TotalsInformationInterface $addressInformation
     * @return mixed
     */
    public function calculate(
        CartInterface $quote,
        TotalsInformationInterface $addressInformation
    );
}
