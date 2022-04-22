<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Checkout\Api\Data\TotalsInformationInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;

/**
 * Class QuoteBuilder
 * @package Punchout2Go\PurchaseOrder\Model
 */
class QuoteBuildContainer implements QuoteBuildContainerInterface
{
    /**
     * @var null
     */
    protected $quote = null;

    /**
     * @var null
     */
    protected $billingAddress = null;

    /**
     * @var null
     */
    protected $shipping = null;

    /**
     * @var null
     */
    protected $customer = null;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var null
     */
    protected $payment = null;

    /**
     * @var null
     */
    protected $taxAmount = null;

    /**
     * @var null
     */
    protected $discountAmount = null;

    /**
     * @return CartInterface|null
     */
    public function getQuote(): ?CartInterface
    {
        return $this->quote;
    }

    /**
     * @param CartInterface $cart
     * @return QuoteBuildContainerInterface
     */
    public function setQuote(CartInterface $cart): QuoteBuildContainerInterface
    {
        $this->quote = $cart;
        return $this;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     * @return $this
     */
    public function setCustomer(CustomerInterface $customer): QuoteBuildContainerInterface
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CartItemInterface $items
     * @return $this
     */
    public function addItem(CartItemInterface $items): QuoteBuildContainerInterface
    {
        $this->items[$items->getItemId()] = $items;
        return $this;
    }

    /**
     * @return PaymentInterface|null
     */
    public function getPayment(): ?PaymentInterface
    {
        return $this->payment;
    }

    /**
     * @param PaymentInterface $payment
     * @return QuoteBuildContainerInterface
     */
    public function setPayment(PaymentInterface $payment): QuoteBuildContainerInterface
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return null
     */
    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    /**
     * @param null $taxAmount
     * @return QuoteBuildContainer
     */
    public function setTaxAmount($taxAmount): QuoteBuildContainerInterface
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     * @param TotalsInformationInterface $totalsInformation
     */
    public function setShippingTotals(TotalsInformationInterface $totalsInformation): QuoteBuildContainerInterface
    {
        $this->shipping = $totalsInformation;
        return $this;
    }

    /**
     * @return TotalsInformationInterface|null
     */
    public function getShippingTotals(): ?TotalsInformationInterface
    {
        return $this->shipping;
    }

    /**
     * @return AddressInterface
     */
    public function getBillingAddress(): AddressInterface
    {
        return $this->billingAddress;
    }

    /**
     * @param AddressInterface $address
     * @return QuoteBuildContainerInterface
     */
    public function setBillingAddress(AddressInterface $address): QuoteBuildContainerInterface
    {
        $this->billingAddress = $address;
        return $this;
    }
}
