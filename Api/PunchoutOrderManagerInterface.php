<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PunchoutOrderManagerInterface
{
    /**
     * @param string $params
     * @return int
     */
    public function create(
        string $params
    ): ?int;
}
