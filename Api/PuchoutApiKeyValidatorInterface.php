<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * Interface PuchoutApiKeyValidatorInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PuchoutApiKeyValidatorInterface
{
    /**
     * @param string $apiKey
     * @return bool
     */
    public function isValid(string $apiKey): bool;
}
