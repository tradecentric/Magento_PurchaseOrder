<?php

namespace Punchout2Go\PurchaseOrder\Model\Transfer\QuoteDataHandlers;

use Punchout2Go\Punchout\Model\Transfer\QuoteDataHandlerInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

class Fpt implements QuoteDataHandlerInterface
{
    public function __construct() {}

    /**
     * @param \Magento\Quote\Api\Data\CartInterface $cart
     * @return array
     */
    public function handle(\Magento\Quote\Api\Data\CartInterface $cart): array
    {
        $result = [
            'custom_fields' => []
        ];

        foreach ($cart->getItems() as $item) {
            $weeTax = $item->getWeeeTaxApplied();
            if ($weeTax) {
                $weeTax = json_decode($weeTax, true);
                foreach ($weeTax as $tax) {
                    $taxTotalCode = Data::prepareTaxTotalName($tax['title']);
                    if (!array_key_exists($taxTotalCode, $result['custom_fields'])) $result['custom_fields'][$taxTotalCode] = [
                        'field' => $taxTotalCode,
                        'value' => 0
                    ];

                    $result['custom_fields'][$taxTotalCode]['value'] += $tax['row_amount'];
                }
            }
        }

        return $result;
    }
}