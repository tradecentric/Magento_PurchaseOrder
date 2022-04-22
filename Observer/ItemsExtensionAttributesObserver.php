<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ItemsExtensionAttributesObserver
 * @package Punchout2Go\PurchaseOrder\Observer
 */
class ItemsExtensionAttributesObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $result = $observer->getQuote();
        $payment = $result->getPayment();
        foreach ($result->getAllVisibleItems() as $item) {
            $item->getExtensionAttributes()->setOrderRequestId($result->getOrderRequestId());
            $item->getExtensionAttributes()->setPoNumber($payment->getPoNumber());
        }
    }
}
