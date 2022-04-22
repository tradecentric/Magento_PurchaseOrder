<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Logger\Handlers;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger as MonologLogger;

/**
 * Class Exception
 * @package Ecomitize\DigitalRetailerBase\Logger\Handlers
 */
class Exception  extends Base
{
    protected $fileName = 'var/log/punchout-orders/exception.log';
    protected $loggerType = MonologLogger::ERROR;
}
