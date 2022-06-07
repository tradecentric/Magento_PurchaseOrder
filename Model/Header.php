<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\HeaderInterface;

/**
 * Class Header
 * @package Punchout2Go\PurchaseOrder\Model
 */
class Header implements HeaderInterface
{
    /**
     * @var string
     */
    protected $from_domain;

    /**
     * @var string
     */
    protected $from_identity;

    /**
     * @var string
     */
    protected $to_domain;

    /**
     * @var string
     */
    protected $to_identity;

    /**
     * @var string
     */
    protected $shared_secret;

    /**
     * @var string
     */
    protected $po_payload_id;

    /**
     * @var string
     */
    protected $po_order_id;

    /**
     * @var string
     */
    protected $po_order_date;

    /**
     * @var string
     */
    protected $po_order_type;

    /**
     * @var string
     */
    protected $requested_delivery_date;

    /**
     * @var string
     */
    protected $payment_term;

    /**
     * @var string
     */
    protected $payment_term_days;

    /**
     * @var string
     */
    protected $order_request_id;

    /**
     * @return mixed
     */
    public function getFromDomain(): ?string
    {
        return $this->from_domain;
    }

/**
 * @param string $from_domain
 * @return HeaderInterface
 */
    public function setFromDomain(string $from_domain): HeaderInterface
    {
        $this->from_domain = $from_domain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromIdentity(): ?string
    {
        return $this->from_identity;
    }

    /**
     * @param mixed $from_identity
     * @return Header
     */
    public function setFromIdentity(string $from_identity): HeaderInterface
    {
        $this->from_identity = $from_identity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToDomain(): ?string
    {
        return $this->to_domain;
    }

    /**
     * @param mixed $to_domain
     * @return Header
     */
    public function setToDomain(string $to_domain): HeaderInterface
    {
        $this->to_domain = $to_domain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToIdentity(): ?string
    {
        return $this->to_identity;
    }

    /**
     * @param mixed $to_identity
     * @return Header
     */
    public function setToIdentity(string $to_identity): HeaderInterface
    {
        $this->to_identity = $to_identity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharedSecret(): ?string
    {
        return $this->shared_secret;
    }

    /**
     * @param mixed $shared_secret
     * @return Header
     */
    public function setSharedSecret(string $shared_secret): HeaderInterface
    {
        $this->shared_secret = $shared_secret;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoPayloadId(): ?string
    {
        return $this->po_payload_id;
    }

    /**
     * @param mixed $po_payload_id
     * @return Header
     */
    public function setPoPayloadId(string $po_payload_id) :HeaderInterface
    {
        $this->po_payload_id = $po_payload_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoOrderId() :?string
    {
        return $this->po_order_id;
    }

    /**
     * @param mixed $po_order_id
     * @return Header
     */
    public function setPoOrderId(string $po_order_id): HeaderInterface
    {
        $this->po_order_id = $po_order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoOrderDate(): ?string
    {
        return $this->po_order_date;
    }

    /**
     * @param mixed $po_order_date
     * @return Header
     */
    public function setPoOrderDate(string $po_order_date): HeaderInterface
    {
        $this->po_order_date = $po_order_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoOrderType(): ?string
    {
        return $this->po_order_type;
    }

    /**
     * @param mixed $po_order_type
     * @return Header
     */
    public function setPoOrderType(string $po_order_type): HeaderInterface
    {
        $this->po_order_type = $po_order_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestedDeliveryDate(): ?string
    {
        return $this->requested_delivery_date;
    }

    /**
     * @param mixed $requested_delivery_date
     * @return Header
     */
    public function setRequestedDeliveryDate(string $requested_delivery_date): HeaderInterface
    {
        $this->requested_delivery_date = $requested_delivery_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTerm(): ?string
    {
        return $this->payment_term;
    }

    /**
     * @param mixed $payment_term
     * @return Header
     */
    public function setPaymentTerm(string $payment_term): HeaderInterface
    {
        $this->payment_term = $payment_term;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTermDays(): ?string
    {
        return $this->payment_term_days;
    }

    /**
     * @param mixed $payment_term_days
     * @return Header
     */
    public function setPaymentTermDays(string $payment_term_days): HeaderInterface
    {
        $this->payment_term_days = $payment_term_days;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderRequestId(): ?string
    {
        return $this->order_request_id;
    }

    /**
     * @param mixed $order_request_id
     * @return Header
     */
    public function setOrderRequestId(string $order_request_id): HeaderInterface
    {
        $this->order_request_id = $order_request_id;
        return $this;
    }
}
