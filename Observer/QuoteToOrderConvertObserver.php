<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class PaymentDataToQuoteObserver
 * @package Punchout2Go\PurchaseOrder\Observer
 */
class QuoteToOrderConvertObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quote = $observer->getQuote();
        $order->getExtensionAttributes()->setIsPurchaseOrder(
            $quote->getExtensionAttributes()->getIsPurchaseOrder()
        );
    }
}
