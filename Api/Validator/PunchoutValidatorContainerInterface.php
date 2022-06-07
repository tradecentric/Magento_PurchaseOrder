<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Validator;

use Punchout2Go\PurchaseOrder\Api\HeaderInterface;

/**
 * Interface PunchoutValidationContainerInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PunchoutValidatorContainerInterface
{
    /**
     * @return HeaderInterface
     */
    public function getHeader(): HeaderInterface;

    /**
     * @return string
     */
    public function getApiKey(): string;

    /**
     * @return string
     */
    public function getSharedSecret(): string;

    /**
     * @return string
     */
    public function getMode(): string;
}
