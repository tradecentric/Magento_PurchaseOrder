<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class PaymentDataToQuoteObserver
 * @package Punchout2Go\PurchaseOrder\Observer
 */
class PaymentDataToQuoteObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getData('data');
        /** @var \Magento\Quote\Model\Quote\Payment $payment */
        $payment = $observer->getPaymentModel();
        $payment->setPoNumber($data->getPoNumber());
        $additionalData = $data->getData('additional_data');
        if (!$additionalData) {
            return;
        }
        if (!isset($additionalData['additional_information'])) {
            return;
        }
        $payment->setAdditionalInformation($additionalData['additional_information']);
    }
}
