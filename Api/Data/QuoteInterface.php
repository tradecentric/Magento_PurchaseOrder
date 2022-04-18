<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface QuoteInterface
{
    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @param int $total
     */
    public function setTotal(int $total): void;

    /**
     * @return int
     */
    public function getShipping(): int;

    /**
     * @param int $shipping
     */
    public function setShipping(int $shipping): void;
    /**
     * @return string
     */
    public function getShippingTitle(): string;

    /**
     * @param string $shippingTitle
     */
    public function setShippingTitle(string $shippingTitle): void;

    /**
     * @return int
     */
    public function getTax(): int;

    /**
     * @param int $tax
     */
    public function setTax(int $tax): void;

    /**
     * @return string
     */
    public function getTaxTitle(): string;

    /**
     * @param string $taxTitle
     */
    public function setTaxTitle(string $taxTitle): void;

    /**
     * @return int
     */
    public function getDiscount(): int;

    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void;

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
     * @param CustomerInterface $customer
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
     * @return int
     */
    public function getMagentoQuoteId(): int;
}
