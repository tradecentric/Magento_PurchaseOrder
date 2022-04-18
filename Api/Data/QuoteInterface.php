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
     * @return float
     */
    public function getTotal(): float;

    /**
     * @param float $total
     */
    public function setTotal(float $total): void;

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
     * @return float
     */
    public function getDiscount(): float;

    /**
     * @param float $discount
     */
    public function setDiscount(float $discount): void;

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
     * @return int
     */
    public function getMagentoQuoteId(): int;
}
