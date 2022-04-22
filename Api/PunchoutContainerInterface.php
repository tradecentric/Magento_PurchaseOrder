<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PunchoutContainerInterface
{
    /**
     * @param bool|null $isPunchout
     * @return bool
     */
    public function isPunchout(bool $isPunchout = null): bool;

    /**
     * @return int
     */
    public function getUserType(): int;

    /**
     * @param int $userType
     */
    public function setUserType(int $userType): void;
}
