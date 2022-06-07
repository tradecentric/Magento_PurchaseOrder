<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface PaymentInterface
{
    /**
     * @return string
     */
    public function getPayloadId(): string;

    /**
     * @param string $payloadId
     */
    public function setPayloadId(string $payloadId): void;

    /**
     * @return string
     */
    public function getOrderRequestId(): string;

    /**
     * @param string $orderRequestId
     */
    public function setOrderRequestId(string $orderRequestId): void;

    /**
     * @return string
     */
    public function getPoPayloadId(): string;

    /**
     * @param string $poPayloadId
     */
    public function setPoPayloadId(string $poPayloadId): void;
}
