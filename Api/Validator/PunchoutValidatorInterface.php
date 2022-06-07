<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Validator;

use Magento\Framework\Validation\ValidationResult;

/**
 * Interface PunchoutValidatorInterface
 * @package Punchout2Go\PurchaseOrder\Api\Validator
 */
interface PunchoutValidatorInterface
{
    /**
     * @param PunchoutValidatorContainerInterface $container
     * @return mixed
     */
    public function validate(PunchoutValidatorContainerInterface $container): ValidationResult;
}
