<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Checkout\Api\Data\TotalsInformationInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Interface QuoteBuilderInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteBuildContainerInterface
{
    /**
     * @param CartInterface $cart
     * @return QuoteBuildContainerInterface
     */
    public function setQuote(CartInterface $cart): QuoteBuildContainerInterface;

    /**
     * @return CartInterface|null
     */
    public function getQuote(): ?CartInterface;

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @param CustomerInterface $customer
     * @return $this
     */
    public function setCustomer(CustomerInterface $customer): QuoteBuildContainerInterface;

    /**
     * @return mixed[]
     */
    public function getItems(): array;

    /**
     * @param CartItemInterface $items
     * @return $this
     */
    public function addItem(CartItemInterface $items): QuoteBuildContainerInterface;

    /**
     * @return PaymentInterface|null
     */
    public function getPayment(): ?PaymentInterface;

    /**
     * @param PaymentInterface $payment
     * @return QuoteBuildContainerInterface
     */
    public function setPayment(PaymentInterface $payment): QuoteBuildContainerInterface;

    /**
     * @return TotalsInformationInterface|null
     */
    public function getShippingTotals(): ?TotalsInformationInterface;

    /**
     * @param TotalsInformationInterface $totalsInformation
     */
    public function setShippingTotals(TotalsInformationInterface $totalsInformation): QuoteBuildContainerInterface;

    /**
     * @return AddressInterface
     */
    public function getBillingAddress(): AddressInterface;

    /**
     * @param AddressInterface $address
     * @return QuoteBuildContainerInterface
     */
    public function setBillingAddress(AddressInterface $address): QuoteBuildContainerInterface;

    /**
     * @return null
     */
    public function getTaxAmount(): ?float;

    /**
     * @param $taxAmount
     * @return QuoteBuildContainerInterface
     */
    public function setTaxAmount($taxAmount): QuoteBuildContainerInterface;
}
