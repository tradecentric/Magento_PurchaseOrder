<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\PaymentInterface;

/**
 * Class Payment
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class Payment implements PaymentInterface
{
    /**
     * @var string
     */
    protected $payloadId = '';

    /**
     * @var string
     */
    protected $poPayloadId = '';

    /**
     * @var string
     */
    protected $orderRequestId = '';

    /**
     * @param string $po_order_id
     * @param string $po_payload_id
     * @param string $order_request_id
     */
    public function __construct(
        string $po_order_id,
        string $po_payload_id,
        string $order_request_id = ''
    ) {
        $this->payloadId = $po_order_id;
        $this->poPayloadId = $po_payload_id;
        $this->orderRequestId = $order_request_id;
    }

    /**
     * @return string
     */
    public function getPayloadId(): string
    {
        return $this->payloadId;
    }

    /**
     * @param string $payloadId
     * @return PaymentInterface
     */
    public function setPayloadId(string $payloadId): PaymentInterface
    {
        $this->payloadId = $payloadId;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderRequestId(): string
    {
        return $this->orderRequestId;
    }

    /**
     * @param string $orderRequestId
     * @return PaymentInterface
     */
    public function setOrderRequestId(string $orderRequestId): PaymentInterface
    {
        $this->orderRequestId = $orderRequestId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPoPayloadId(): string
    {
        return $this->poPayloadId;
    }

    /**
     * @param string $poPayloadId
     * @return PaymentInterface
     */
    public function setPoPayloadId(string $poPayloadId): PaymentInterface
    {
        $this->poPayloadId = $poPayloadId;
        return $this;
    }
}
