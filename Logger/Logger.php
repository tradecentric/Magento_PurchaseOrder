<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Logger;

use Punchout2Go\PurchaseOrder\Api\StoreAwareInterface;
use Punchout2go\Purchaseorder\Helper\Data;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package Punchout2Go\PurchaseOrder\Logger
 */
class Logger implements StoreLoggerInterface
{
    /**
     * @var string
     */
    protected $storeId = null;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Data $helper,
        LoggerInterface $logger
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * @param $storeId
     * @return StoreAwareInterface
     */
    public function setStoreId($storeId): StoreAwareInterface
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * @param $message
     * @param array $context
     * @return mixed|void
     */
    public function info($message, array $context = array())
    {
        if ($this->helper->isLogging($this->storeId)) {
            $this->logger->info($message, $context);
        }
    }

    /**
     * @param $message
     * @param array $context
     * @return mixed|void
     */
    public function error($message, array $context = array())
    {
        if ($this->helper->isLogging($this->storeId)) {
            $this->logger->error($message, $context);
        }
    }
}
