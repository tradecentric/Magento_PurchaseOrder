<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * Interface PunchoutStoreValidatorInterface
 * @package Punchout2Go\PurchaseOrder\Api\Validator
 */
interface StoreAwareInterface
{
    /**
     * @param $storeId
     * @return StoreAwareInterface
     */
    public function setStoreId($storeId): StoreAwareInterface;
}
