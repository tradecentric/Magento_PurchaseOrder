<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator;

use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator
 */
class ModeValidator implements PuchoutOrderRequestValidatorInterface
{
    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    public function validate(PunchoutOrderRequestDtoInterface $request): array
    {
        $result = [];
        foreach ($request->getQuoteDetails()->getItemsData() as $itemCounter => $item) {
            if (!property_exists($item, 'supplier_aux_id')) {
                $result[] = __('Supplier_aux_id missing from item ' . ($itemCounter + 1));
                continue;
            }
            $splitAuxId = explode('/', $item['supplier_aux_id']);
            if (!count($splitAuxId) == 2) {
                $result[] = __('Invalid supplier_aux_id: ' . $item['supplier_aux_id']);
                continue;
            }
            if (!is_numeric($splitAuxId[0]) || !is_numeric($splitAuxId[1])) {
                $result[] = __('Invalid supplier_aux_id, non-numeric values: ' . $item['supplier_aux_id']);
            }
        }
        return $result;
    }
}
