<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Store\Api\Data\StoreInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PaymentInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\HeaderInterface;

/**
 * Class PunchoutQuoteExtender
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutQuoteExtender
{

    /**
     * @var PaymentInterfaceFactory
     */
    protected $paymentFactory;

    /**
     * PunchoutQuoteExtender constructor.
     * @param PaymentInterfaceFactory $paymentFactory
     */
    public function __construct(
        PaymentInterfaceFactory $paymentFactory
    ) {
        $this->paymentFactory = $paymentFactory;
    }

    /**
     * @param PunchoutQuoteInterface $quote
     * @param HeaderInterface $header
     * @param StoreInterface $store
     * @param array $items
     * @return PunchoutQuoteInterface
     */
    public function extend(
        PunchoutQuoteInterface $quote,
        HeaderInterface $header,
        StoreInterface $store,
        array $items
    ) : PunchoutQuoteInterface {
        $quote->setOrderRequestId((string) $header->getOrderRequestId());
        $quote->setStoreId((string) $store->getId());
        foreach ($items as $requestItem) {
            $quote->addItem($requestItem);
        }
        $quote->setPayment($this->paymentFactory->create(
            [
                 'po_order_id' => $header->getPoOrderId(),
                 'po_payload_id' => $header->getPoPayloadId(),
                 'order_request_id' => $header->getOrderRequestId()
            ]
        ));
        $quote->setExtraData(
            array_merge(
                [],
                $quote->getExtraData(),
                $header->getExtraData(),
                $quote->getBillTo()->getExtraData(),
                $quote->getShipTo()->getExtraData(),
                $quote->getContact()->getExtraData()
            ));
        return $quote;
    }
}
