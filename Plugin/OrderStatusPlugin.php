<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\Handler\State;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class OrderStatusPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class OrderStatusPlugin
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param State $subject
     * @param State $result
     * @param Order $order
     * @return State
     */
    public function afterCheck(
        State $subject,
        State $result,
        Order $order
    ) {
        if (!$order->getExtensionAttributes()->getIsPurchaseOrder()) {
            return $result;
        }
        $newStatus = $this->helper->getOrderSuccessStatus($order->getStoreId());
        if (!$newStatus) {
            return $result;
        }
        if ($newStatus === $order->getStatus()) {
            return $result;
        }
        $order->setState($newStatus)->setStatus($newStatus);
        return $result;
    }
}
