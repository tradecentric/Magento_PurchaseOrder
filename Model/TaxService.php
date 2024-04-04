<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Pricing\PriceCurrencyInterface as PriceRounder;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Tax\Model\Sales\Total\Quote\Tax;
use Punchout2Go\PurchaseOrder\Api\TaxServiceInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class TaxService
 * @package Punchout2Go\PurchaseOrder\Model
 */
class TaxService implements TaxServiceInterface
{
    const TAX_CODE = 'Punchout Tax';

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var PriceRounder
     */
    protected $priceRounder;

    /**
     * TaxCollectorPlugin constructor.
     * @param Data $helper
     * @param PriceRounder $priceRounder
     */
    public function __construct(Data $helper, PriceRounder $priceRounder)
    {
        $this->helper = $helper;
        $this->priceRounder = $priceRounder;
    }

    /**
     *
     * @param Total $total
     * @param string $taxFieldCode
     * @param float $taxPrice
     * @param null $storeId
     * @return bool
     */
    public function addCustomTaxesToTotals(Total $total, string $taxFieldCode, float $taxPrice, $storeId = null): bool
    {
        if (!$taxPrice) {
            return false;
        }
        if (!$this->helper->isAllowedTaxes($storeId)) {
            return false;
        }
        $punchoutOrderTax = $this->round($taxPrice);
        $total->setBaseSubtotalInclTax($this->round($total->getBaseSubtotalInclTax() - $total->getBaseTaxAmount() + $punchoutOrderTax));
        $total->setBaseSubtotalTotalInclTax($this->round($total->getBaseSubtotalTotalInclTax() - $total->getBaseTaxAmount() + $punchoutOrderTax));
        $total->setBaseTotalAmount($taxFieldCode, $punchoutOrderTax);

        $total->setSubtotalInclTax($this->round($total->getSubtotalInclTax() - $total->getTaxAmount() + $punchoutOrderTax));
        $total->setTotalAmount($taxFieldCode, $punchoutOrderTax);

        $total->setAppliedTaxes($this->getAppliedTaxes($punchoutOrderTax));
        $total->setItemsAppliedTaxes($this->clearTaxes($total->getItemsAppliedTaxes()));
        return true;
    }

    /**
     * @param $punchoutOrderTax
     * @return mixed[][]
     */
    protected function getAppliedTaxes($punchoutOrderTax)
    {
        return [
            static::TAX_CODE => [
                'id' => static::TAX_CODE,
                'amount' => $punchoutOrderTax,
                'base_amount' => $punchoutOrderTax,
                'item_type' => Tax::ITEM_TYPE_PRODUCT,
                'rates' => []
            ]
        ];
    }

    /**
     * @param array $taxes
     * @return mixed[]
     */
    protected function clearTaxes(array $taxes)
    {
        array_walk($taxes , function(&$item, $key) {
            if ($key != Tax::ITEM_CODE_SHIPPING) {
                $item = [];
            }
        });
        return $taxes;
    }

    /**
     * @param $value
     * @return float
     */
    protected function round($value)
    {
        return $this->priceRounder->round($value, 4);
    }
}
