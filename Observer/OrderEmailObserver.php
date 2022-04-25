<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class PaymentDataToQuoteObserver
 * @package Punchout2Go\PurchaseOrder\Observer
 */
class OrderEmailObserver implements ObserverInterface
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
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        if (!$order->getExtensionAttributes()->getIsPurchaseOrder()) {
            return;
        }
        $order->setCanSendNewEmailFlag($this->helper->isCustomerNotify($order->getStoreId()));
    }
}
