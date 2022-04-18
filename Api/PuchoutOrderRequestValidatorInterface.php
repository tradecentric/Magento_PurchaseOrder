<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PuchoutOrderRequestValidatorInterface
{
    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    public function validate(PunchoutOrderRequestDtoInterface $request): array;
}
