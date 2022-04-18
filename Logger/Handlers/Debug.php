<?php
declare(strict_types=1);

namespace Ecomitize\PurchaseOrder\Logger\Handlers;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger as MonologLogger;

/**
 * Class Debug
 * @package Ecomitize\DigitalRetailerBase\Logger\Handlers
 */
class Debug extends Base
{
    protected $fileName = 'var/log/punchout-orders/debug.log';
    protected $loggerType = MonologLogger::DEBUG;
}
