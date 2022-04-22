<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Quote\Api\Data\CartItemInterface;

/**
 * Class QuoteToOrderItemPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteToOrderItemPlugin
{
    /**
     * @param ToOrderItem $subject
     * @param OrderItemInterface $result
     * @param CartItemInterface $item
     * @return OrderItemInterface
     */
    public function afterConvert(
        ToOrderItem $subject,
        OrderItemInterface $result,
        CartItemInterface $item
    ) {
        $result->getExtensionAttributes()->setLineNumber((string) $item->getExtensionAttributes()->getLineNumber());
        $result->getExtensionAttributes()->setOrderRequestId((string) $item->getExtensionAttributes()->getOrderRequestId());
        $result->getExtensionAttributes()->setPoNumber((string) $item->getExtensionAttributes()->getPoNumber());
        return $result;
    }
}
