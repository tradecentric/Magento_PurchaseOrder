<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

use Punchout2Go\PurchaseOrder\Api\HeaderInterface;
use Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

/**
 * Interface PunchoutQuoteInterface
 * @package Punchout2Go\PurchaseOrder\Api\PunchoutData
 */
interface PunchoutQuoteInterface
{
    /**
     * @return string
     */
    public function getCurrency(): ?string;

    /**
     * @param string $currency
     * @return PunchoutQuote
     */
    public function setCurrency(string $currency): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getTotal(): ?string;

    /**
     * @param string $total
     * @return PunchoutQuote
     */
    public function setTotal(string $total): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getShipping(): ?string;

    /**
     * @param string $shipping
     * @return PunchoutQuote
     */
    public function setShipping(string $shipping): PunchoutQuoteInterface;

    /**
     * @return string|null
     */
    public function getShippingCode(): ?string;

    /**
     * @param string $shipping_code
     * @return PunchoutQuoteInterface
     */
    public function setShippingCode(string $shipping_code): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getShippingTitle(): ?string;

    /**
     * @param string $shipping_title
     * @return PunchoutQuote
     */
    public function setShippingTitle(string $shipping_title): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getTax(): ?string;

    /**
     * @param string $tax
     * @return PunchoutQuote
     */
    public function setTax(string $tax): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getTaxTitle(): ?string;

    /**
     * @param string $tax_title
     * @return PunchoutQuote
     */
    public function setTaxTitle(string $tax_title): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getDiscount(): ?string;

    /**
     * @param string $discount
     * @return PunchoutQuote
     */
    public function setDiscount(string $discount): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getDiscountTitle(): ?string;

    /**
     * @param string $discount_title
     * @return PunchoutQuote
     */
    public function setDiscountTitle(string $discount_title): PunchoutQuoteInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface
     */
    public function getShipTo(): ?AddressInterface;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface $ship_to
     * @return PunchoutQuoteInterface
     */
    public function setShipTo(AddressInterface $ship_to): PunchoutQuoteInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface
     */
    public function getBillTo(): ?AddressInterface;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface $bill_to
     * @return PunchoutQuoteInterface
     */
    public function setBillTo(AddressInterface $bill_to): PunchoutQuoteInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface
     */
    public function getContact(): ?CustomerInterface;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface $contact
     * @return PunchoutQuoteInterface
     */
    public function setContact(CustomerInterface $contact): PunchoutQuoteInterface;

    /**
     * @param PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment): PunchoutQuoteInterface;

    /**
     * @return PaymentInterface
     */
    public function getPayment(): PaymentInterface;

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int;

    /**
     * @return string
     */
    public function getStoreId(): string;

    /**
     * @param string $storeId
     * @return mixed
     */
    public function setStoreId(string $storeId);

    /**
     * @param string $orderRequestId
     */
    public function setOrderRequestId(string $orderRequestId): PunchoutQuoteInterface;

    /**
     * @return string
     */
    public function getOrderRequestId(): string;

    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param QuoteItemInterface $item
     */
    public function addItem(QuoteItemInterface $item): PunchoutQuoteInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[]
     */
    public function getExtraData(): array;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[] $extra_data
     * @return PunchoutQuoteInterface
     */
    public function setExtraData(array $extra_data): PunchoutQuoteInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[]
     */
    public function getFixedProductTax(): array;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[] $fixedProductTax
     * @return PunchoutQuoteInterface
     */
    public function setFixedProductTax(array $fixedProductTax): PunchoutQuoteInterface;
}
