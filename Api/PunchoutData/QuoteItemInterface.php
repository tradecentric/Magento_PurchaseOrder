<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * Interface QuoteItemInterface
 * @package Punchout2Go\PurchaseOrder\Api\PunchoutData
 */
interface QuoteItemInterface
{
    /**
     * @return string
     */
    public function getLineNumber(): ?string;

    /**
     * @param string $line_number
     * @return QuoteItemInterface
     */
    public function setLineNumber(string $line_number): QuoteItemInterface;

    /**
     * @return string
     */
    public function getRequestedDeliveryDate(): ?string;

    /**
     * @param string $requested_delivery_date
     * @return QuoteItemInterface
     */
    public function setRequestedDeliveryDate(string $requested_delivery_date): QuoteItemInterface;

    /**
     * @return string
     */
    public function getQuantity(): ?string;

    /**
     * @param string $quantity
     * @return QuoteItemInterface
     */
    public function setQuantity(string $quantity): QuoteItemInterface;

    /**
     * @return string
     */
    public function getSupplierId(): ?string;

    /**
     * @param string $supplier_id
     * @return QuoteItemInterface
     */
    public function setSupplierId(string $supplier_id): QuoteItemInterface;

    /**
     * @return string
     */
    public function getSupplierAuxId(): ?string;

    /**
     * @param string $supplier_aux_id
     * @return QuoteItemInterface
     */
    public function setSupplierAuxId(string $supplier_aux_id): QuoteItemInterface;

    /**
     * @return string
     */
    public function getUnitprice(): ?string;

    /**
     * @param string $unitprice
     * @return QuoteItemInterface
     */
    public function setUnitprice(string $unitprice): QuoteItemInterface;

    /**
     * @return string
     */
    public function getCurrency(): ?string;

    /**
     * @param string $currency
     * @return QuoteItemInterface
     */
    public function setCurrency(string $currency): QuoteItemInterface;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @param string $description
     * @return QuoteItemInterface
     */
    public function setDescription(string $description): QuoteItemInterface;

    /**
     * @return string
     */
    public function getUom(): ?string;

    /**
     * @param string $uom
     * @return QuoteItemInterface
     */
    public function setUom(string $uom): QuoteItemInterface;

    /**
     * @return string
     */
    public function getComments(): ?string;

    /**
     * @param string $comments
     * @return QuoteItemInterface
     */
    public function setComments(string $comments): QuoteItemInterface;

    /**
     * @return string
     */
    public function getSessionKey(): ?string;

    /**
     * @param string $session_key
     * @return QuoteItemInterface
     */
    public function setSessionKey(string $session_key): QuoteItemInterface;

    /**
     * @return string
     */
    public function getCartPosition(): ?string;

    /**
     * @param string $cart_position
     * @return QuoteItemInterface
     */
    public function setCartPosition(string $cart_position): QuoteItemInterface;

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int;

    /**
     * @return int
     */
    public function getMagentoItemId(): int;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[]
     */
    public function getExtraData(): array;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[] $extra_data
     * @return QuoteItemInterface
     */
    public function setExtraData(array $extra_data): QuoteItemInterface;
}
