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
     */
    public function setPayloadId(string $payloadId): void
    {
        $this->payloadId = $payloadId;
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
     */
    public function setOrderRequestId(string $orderRequestId): void
    {
        $this->orderRequestId = $orderRequestId;
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
     */
    public function setPoPayloadId(string $poPayloadId): void
    {
        $this->poPayloadId = $poPayloadId;
    }
}
