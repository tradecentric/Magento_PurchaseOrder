<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Authorization;

use Punchout2Go\PurchaseOrder\Api\PunchoutContainerInterface;

/**
 * Class PunchoutContainer
 * @package Punchout2Go\PurchaseOrder\Model\Authorization
 */
class PunchoutContainer implements PunchoutContainerInterface
{
    /**
     * @var bool
     */
    protected $isPunchout = false;

    /**
     * @var string
     */
    protected $userType = 0;

    /**
     * @param bool|null $isPunchout
     * @return bool
     */
    public function isPunchout(bool $isPunchout = null): bool
    {
        if ($isPunchout !== null) {
            $this->isPunchout = $isPunchout;
        }
        return $this->isPunchout;
    }

    /**
     * @param int $userType
     */
    public function setUserType(int $userType): void
    {
        $this->userType = $userType;
    }

    /**
     * @return int
     */
    public function getUserType(): int
    {
        return $this->userType;
    }
}
