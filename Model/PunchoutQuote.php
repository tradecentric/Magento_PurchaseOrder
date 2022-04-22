<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PaymentInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ShippingInterface;

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
    protected $total = "";

    /**
     * @var int
     */
    protected $tax = "";

    /**
     * @var string
     */
    protected $taxTitle = "";

    /**
     * @var int
     */
    protected $discount = "";

    /**
     * @var string
     */
    protected $discountTitle = "";

    /**
     * @var string
     */
    protected $storeId = "";

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
     * @var string
     */
    protected $orderRequestId = '';

    /**
     * @var ShippingInterface
     */
    protected $shipping;

    /**
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * @var null
     */
    protected $magentoQuoteId = null;


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
        string $store_code = "",
        string $orderRequestId = ""
    ) {
        $this->currency = $currency;
        $this->total = $total;
        $this->tax = $tax;
        $this->taxTitle = $tax_title;
        $this->discount = $discount;
        $this->discountTitle = $discount_title;
        $this->storeCode = $store_code;
        $this->orderRequestId = $orderRequestId;
    }

    /**
     * @param string $orderRequestId
     */
    public function setOrderRequestId(string $orderRequestId): void
    {
        $this->orderRequestId = $orderRequestId;
    }

    /**
     * @return string
     */
    public function getOrderRequestId(): string
    {
        return $this->orderRequestId;
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
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal(string $total): void
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     */
    public function setTax(string $tax): void
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
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     */
    public function setDiscount(string $discount): void
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
        $address = array_filter($this->getAddresses(), function (AddressInterface $address) use ($type) {
            return $address->getType() === $type;
        });
        return current($address);
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
     * @param string $storeId
     */
    public function setStoreId(string $storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getStoreId(): string
    {
        return $this->storeId;
    }
}
