<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Quote\Model\Quote\Address;
use Punchout2Go\PurchaseOrder\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\Data\CustomerInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutQuote implements QuoteInterface
{
    /**
     * @var string
     */
    protected $currency = "";

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @var int
     */
    protected $shipping = 0;

    /**
     * @var string
     */
    protected $shippingTitle = "";

    /**
     * @var int
     */
    protected $tax = 0;

    /**
     * @var string
     */
    protected $taxTitle = "";

    /**
     * @var int
     */
    protected $discount = 0;

    /**
     * @var string
     */
    protected $discountTitle = "";

    /**
     * @var []AddressInterface
     */
    protected $addresses = [];

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var CustomerInterface
     */
    protected $customer = null;

    /**
     * @var string
     */
    protected $storeCode = "";

    /**
     * @var null
     */
    protected $magentoQuoteId = null;

    /**
     * @param string $currency
     * @param int $total
     * @param int $shipping
     * @param string $shipping_title
     * @param int $tax
     * @param string $tax_title
     * @param int $discount
     * @param string $discount_title
     * @param string $store_code
     */
    public function __construct(
        string $currency,
        int $total,
        int $shipping,
        string $shipping_title,
        int $tax,
        string $tax_title,
        int $discount,
        string $discount_title,
        string $store_code
    ) {
        $this->currency = $currency;
        $this->total = $total;
        $this->shipping = $shipping;
        $this->shippingTitle = $shipping_title;
        $this->tax = $tax;
        $this->taxTitle = $tax_title;
        $this->discount = $discount;
        $this->discountTitle = $discount_title;
        $this->storeCode = $store_code;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getShipping(): int
    {
        return $this->shipping;
    }

    /**
     * @param int $shipping
     */
    public function setShipping(int $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return string
     */
    public function getShippingTitle(): string
    {
        return $this->shippingTitle;
    }

    /**
     * @param string $shippingTitle
     */
    public function setShippingTitle(string $shippingTitle): void
    {
        $this->shippingTitle = $shippingTitle;
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     */
    public function setTax(int $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return string
     */
    public function getTaxTitle(): string
    {
        return $this->taxTitle;
    }

    /**
     * @param string $taxTitle
     */
    public function setTaxTitle(string $taxTitle): void
    {
        $this->taxTitle = $taxTitle;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return string
     */
    public function getDiscountTitle(): string
    {
        return $this->discountTitle;
    }

    /**
     * @param string $discountTitle
     */
    public function setDiscountTitle(string $discountTitle): void
    {
        $this->discountTitle = $discountTitle;
    }

    /**
     * @return mixed
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param mixed $addresses
     */
    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }

    /**
     * @param string $type
     * @return array|mixed
     */
    public function getAddressByType(string $type)
    {
        return array_filter($this->getAddresses(), function (AddressInterface $address) use ($type) {
            return $address->getType() === $type;
        });
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     */
    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getStoreCode(): string
    {
        return $this->storeCode;
    }

    /**
     * @param string $storeCode
     */
    public function setStoreCode(string $storeCode): void
    {
        $this->storeCode = $storeCode;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param AddressInterface $address
     */
    public function addAddress(AddressInterface $address): void
    {
        $this->addresses[] = $address;
    }

    /**
     * @param QuoteItemInterface $item
     */
    public function addItem(QuoteItemInterface $item): void
    {
        $this->items[] = $item;
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
        list($quoteId, ) = explode('/', $firstItem->getSupplierAuxId());
        $this->magentoQuoteId = (int) $quoteId;
        return $this->magentoQuoteId;
    }
}
