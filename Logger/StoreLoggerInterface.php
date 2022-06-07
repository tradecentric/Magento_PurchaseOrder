<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Logger;

use Punchout2Go\PurchaseOrder\Api\StoreAwareInterface;

/**
 * Interface StoreLoggerInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface StoreLoggerInterface extends PunchoutLoggerInterface, StoreAwareInterface {}
