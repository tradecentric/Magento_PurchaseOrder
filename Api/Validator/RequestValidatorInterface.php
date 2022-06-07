<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Validator;

use Punchout2Go\PurchaseOrder\Api\StoreAwareInterface;

/**
 * Interface RequestValidatorInterface
 * @package Punchout2Go\PurchaseOrder\Api\Validator
 */
interface RequestValidatorInterface extends PunchoutValidatorInterface, StoreAwareInterface {}
