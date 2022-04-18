<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Quote\Model\Quote\Address;
use Punchout2Go\PurchaseOrder\Api\Data\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\Data\CustomerInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\Data\ShippingInterface;

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
     * @var ShippingInterface
     */
    protected $shipping;

    /**
     * @var null
     */
    protected $magentoQuoteId = null;


    /**
     * PunchoutQuote constructor.
     * @param string $currency
     * @param float $total
     * @param string $tax
     * @param string $tax_title
     * @param float $discount
     * @param string $discount_title
     * @param string $store_code
     */
    public function __construct(
        string $currency,
        float $total,
        string $tax,
        string $tax_title,
        float $discount,
        string $discount_title,
        string $store_code
    ) {
        $this->currency = $currency;
        $this->total = $total;
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
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
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
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     */
    public function setDiscount(float $discount): void
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
     * @param ShippingInterface $shipping
     */
    public function setShipping(ShippingInterface $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return ShippingInterface
     */
    public function getShipping(): ShippingInterface
    {
        return $this->shipping;
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
