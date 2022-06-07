<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PaymentInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;

/**
 * Class Details
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutOrderRequestDto
 */
class PunchoutQuote implements PunchoutQuoteInterface
{
    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $total;

    /**
     * @var string
     */
    protected $shipping;

    /**
     * @var
     */
    protected $shipping_code;

    /**
     * @var string
     */
    protected $shipping_title;

    /**
     * @var string
     */
    protected $tax;

    /**
     * @var string
     */
    protected $tax_title;

    /**
     * @var string
     */
    protected $discount;

    /**
     * @var string
     */
    protected $discount_title;

    /**
     * @var AddressInterface
     */
    protected $ship_to;

    /**
     * @var AddressInterface
     */
    protected $bill_to;

    /**
     * @var CustomerInterface
     */
    protected $contact;

    /**
     * @var string
     */
    protected $store_id;

    /**
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $order_request_id;

    /**
     * @var int
     */
    protected $magentoQuoteId;

    /**
     * @param string $currency
     * @param string $total
     * @param string $tax
     * @param string $tax_title
     * @param string $discount
     * @param string $discount_title
     * @param string $store_code
     * @param string $orderRequestId
     */
    public function __construct(
        string $currency,
        string $total,
        string $tax,
        string $tax_title,
        string $discount,
        string $discount_title,
        string $store_id = "",
        string $orderRequestId = ""
    ) {
        $this->currency = $currency;
        $this->total = $total;
        $this->tax = $tax;
        $this->tax_title = $tax_title;
        $this->discount = $discount;
        $this->discount_title = $discount_title;
        $this->store_id = $store_id;
        $this->order_request_id = $orderRequestId;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return PunchoutQuote
     */
    public function setCurrency(string $currency): PunchoutQuoteInterface
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotal(): ?string
    {
        return $this->total;
    }

    /**
     * @param string $total
     * @return PunchoutQuote
     */
    public function setTotal(string $total): PunchoutQuoteInterface
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string
     */
    public function getShipping(): ?string
    {
        return $this->shipping;
    }

    /**
     * @param string $shipping
     * @return PunchoutQuote
     */
    public function setShipping(string $shipping): PunchoutQuoteInterface
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCode(): ?string
    {
        return $this->shipping_code;
    }

    /**
     * @param string $shipping_code
     * @return PunchoutQuoteInterface
     */
    public function setShippingCode(string $shipping_code): PunchoutQuoteInterface
    {
        $this->shipping_code = $shipping_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingTitle(): ?string
    {
        return $this->shipping_title;
    }

    /**
     * @param string $shipping_title
     * @return PunchoutQuote
     */
    public function setShippingTitle(string $shipping_title): PunchoutQuoteInterface
    {
        $this->shipping_title = $shipping_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTax(): ?string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     * @return PunchoutQuote
     */
    public function setTax(string $tax): PunchoutQuoteInterface
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxTitle(): ?string
    {
        return $this->tax_title;
    }

    /**
     * @param string $tax_title
     * @return PunchoutQuote
     */
    public function setTaxTitle(string $tax_title): PunchoutQuoteInterface
    {
        $this->tax_title = $tax_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     * @return PunchoutQuote
     */
    public function setDiscount(string $discount): PunchoutQuoteInterface
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountTitle(): ?string
    {
        return $this->discount_title;
    }

    /**
     * @param string $discount_title
     * @return PunchoutQuote
     */
    public function setDiscountTitle(string $discount_title): PunchoutQuoteInterface
    {
        $this->discount_title = $discount_title;
        return $this;
    }

    /**
     * @return AddressInterface|null
     */
    public function getShipTo(): ?AddressInterface
    {
        return $this->ship_to;
    }

    /**
     * @param AddressInterface $ship_to
     * @return $this
     */
    public function setShipTo(AddressInterface $ship_to): PunchoutQuoteInterface
    {
        $this->ship_to = $ship_to;
        return $this;
    }

    /**
     * @return AddressInterface
     */
    public function getBillTo(): ?AddressInterface
    {
        return $this->bill_to;
    }

    /**
     * @param AddressInterface $bill_to
     * @return $this
     */
    public function setBillTo(AddressInterface $bill_to): PunchoutQuoteInterface
    {
        $this->bill_to = $bill_to;
        return $this;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getContact(): ?CustomerInterface
    {
        return $this->contact;
    }

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int
    {
        if ($this->magentoQuoteId !== null) {
            return $this->magentoQuoteId;
        }
        $firstItem = current($this->getItems());
        $this->magentoQuoteId = $firstItem->getMagentoQuoteId();
        return $this->magentoQuoteId;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param QuoteItemInterface $item
     */
    public function addItem(QuoteItemInterface $item): PunchoutQuoteInterface
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param CustomerInterface $contact
     * @return $this
     */
    public function setContact(CustomerInterface $contact): PunchoutQuoteInterface
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @param PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return PaymentInterface
     */
    public function getPayment(): PaymentInterface
    {
        return $this->payment;
    }

    /**
     * @param string $orderRequestId
     */
    public function setOrderRequestId(string $orderRequestId): void
    {
        $this->order_request_id = $orderRequestId;
    }

    /**
     * @return string
     */
    public function getOrderRequestId(): string
    {
        return $this->order_request_id;
    }

    /**
     * @param string $storeId
     */
    public function setStoreId(string $storeId)
    {
        $this->store_id = $storeId;
    }

    /**
     * @return string
     */
    public function getStoreId(): string
    {
        return $this->store_id;
    }

}
