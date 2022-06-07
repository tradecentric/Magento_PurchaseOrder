<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Punchout2Go\PurchaseOrder\Model\PunchoutOrderRequestDto\Header;

/**
 * Interface HeaderInterface
 * @package Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDto
 */
interface HeaderInterface
{
    /**
     * @return string|null
     */
    public function getFromDomain(): ?string;

    /**
     * @param string $from_domain
     * @return HeaderInterface
     */
    public function setFromDomain(string $from_domain): HeaderInterface;

    /**
     * @return string
     */
    public function getFromIdentity(): ?string;

    /**
     * @param string $from_identity
     * @return HeaderInterface
     */
    public function setFromIdentity(string $from_identity): HeaderInterface;

    /**
     * @return string
     */
    public function getToDomain(): ?string;

    /**
     * @param string $to_domain
     * @return HeaderInterface
     */
    public function setToDomain(string $to_domain): HeaderInterface;

    /**
     * @return string|null
     */
    public function getToIdentity(): ?string;

    /**
     * @param string $to_identity
     * @return HeaderInterface
     */
    public function setToIdentity(string $to_identity): HeaderInterface;

    /**
     * @return string|null
     */
    public function getSharedSecret(): ?string;

    /**
     * @param string $shared_secret
     * @return HeaderInterface
     */
    public function setSharedSecret(string $shared_secret): HeaderInterface;

    /**
     * @return string|null
     */
    public function getPoPayloadId(): ?string;

    /**
     * @param mixed $po_payload_id
     * @return Header
     */
    public function setPoPayloadId(string $po_payload_id): HeaderInterface;

    /**
     * @return string|null
     */
    public function getPoOrderId(): ?string;

    /**
     * @param string $po_order_id
     * @return HeaderInterface
     */
    public function setPoOrderId(string $po_order_id): HeaderInterface;

    /**
     * @return string
     */
    public function getPoOrderDate(): ?string;

    /**
     * @param string $po_order_date
     * @return HeaderInterface
     */
    public function setPoOrderDate(string $po_order_date): HeaderInterface;

    /**
     * @return string
     */
    public function getPoOrderType(): ?string;

    /**
     * @param string $po_order_type
     * @return HeaderInterface
     */
    public function setPoOrderType(string $po_order_type): HeaderInterface;

    /**
     * @return string|null
     */
    public function getRequestedDeliveryDate(): ?string;

    /**
     * @param string $requested_delivery_date
     * @return HeaderInterface
     */
    public function setRequestedDeliveryDate(string $requested_delivery_date): HeaderInterface;

    /**
     * @return string|null
     */
    public function getPaymentTerm(): ?string;
    /**
     * @param string $payment_term
     * @return HeaderInterface
     */
    public function setPaymentTerm(string $payment_term): HeaderInterface;

    /**
     * @return string|null
     */
    public function getPaymentTermDays(): ?string;

    /**
     * @param string $payment_term_days
     * @return HeaderInterface
     */
    public function setPaymentTermDays(string $payment_term_days): HeaderInterface;

    /**
     * @return string|null
     */
    public function getOrderRequestId(): ?string;

    /**
     * @param string $order_request_id
     * @return mixed
     */
    public function setOrderRequestId(string $order_request_id): HeaderInterface;
}
