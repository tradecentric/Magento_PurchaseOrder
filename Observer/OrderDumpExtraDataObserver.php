<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class OrderDumpExtraDataObserver
 * @package Punchout2Go\PurchaseOrder\Observer
 */
class OrderDumpExtraDataObserver implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $json;

    /**
     * @param Json $json
     */
    public function __construct(Json $json)
    {
        $this->json = $json;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quote = $observer->getQuote();
        $data = [];
        foreach ((array) $quote->getExtensionAttributes()->getExtraData() as $extraData) {
            $data[$extraData->getName()] = $extraData->getValue();
        }
        if ($data) {
            $order->addStatusHistoryComment($this->json->serialize($data));
        }
    }
}
