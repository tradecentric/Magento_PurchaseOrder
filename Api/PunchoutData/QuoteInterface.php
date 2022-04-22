<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface QuoteInterface
{
    /**
     * @param string $orderRequestId
     */
    public function setOrderRequestId(string $orderRequestId): void;

    /**
     * @return string
     */
    public function getOrderRequestId(): string;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void;

    /**
     * @return string
     */
    public function getTotal(): string;

    /**
     * @param string $total
     */
    public function setTotal(string $total): void;

    /**
     * @return string
     */
    public function getTax(): string;

    /**
     * @param string $tax
     */
    public function setTax(string $tax): void;

    /**
     * @return string
     */
    public function getTaxTitle(): string;

    /**
     * @param string $taxTitle
     */
    public function setTaxTitle(string $taxTitle): void;

    /**
     * @return string
     */
    public function getDiscount(): string;

    /**
     * @param string $discount
     */
    public function setDiscount(string $discount): void;

    /**
     * @return string
     */
    public function getDiscountTitle(): string;

    /**
     * @param string $discountTitle
     */
    public function setDiscountTitle(string $discountTitle): void;

    /**
     * @return mixed
     */
    public function getAddresses(): array;

    /**
     * @param mixed $addresses
     */
    public function setAddresses(array $addresses): void;

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void;

    /**
     * @param string $storeCode
     */
    public function setStoreCode(string $storeCode): void;

    /**
     * @return string
     */
    public function getStoreCode(): string;

    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param array $items
     */
    public function setItems(array $items): void;

    /**
     * @param QuoteItemInterface $item
     */
    public function addItem(QuoteItemInterface $item): void;

    /**
     * @param AddressInterface $address
     */
    public function addAddress(AddressInterface $address): void;

    /**
     * @param ShippingInterface $shipping
     */
    public function setShipping(ShippingInterface $shipping): void;

    /**
     * @return ShippingInterface
     */
    public function getShipping(): ShippingInterface;

    /**
     * @param PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment): void;

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
}
