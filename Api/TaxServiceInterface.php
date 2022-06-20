<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Model\Quote\Address\Total;

/**
 * Interface TaxServiceInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface TaxServiceInterface
{
    /**
     * @param Total $total
     * @param string $taxFieldCode
     * @param float $taxPrice
     * @param null $storeId
     * @return mixed
     */
    public function addCustomTaxesToTotals(Total $total, string $taxFieldCode, float $taxPrice, $storeId = null): bool;

}
