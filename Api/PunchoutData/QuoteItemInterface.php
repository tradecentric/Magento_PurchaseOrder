<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
interface QuoteItemInterface
{
    /**
     * @return string
     */
    public function getLineNumber(): string;

    /**
     * @param string $lineNumber
     */
    public function setLineNumber(string $lineNumber): void;

    /**
     * @return string
     */
    public function getRequestedDeliveryDate(): string;

    /**
     * @param string $requestedDeliveryDate
     */
    public function setRequestedDeliveryDate(string $requestedDeliveryDate): void;

    /**
     * @return string
     */
    public function getQuantity(): string;

    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity): void;

    /**
     * @return string
     */
    public function getSupplierId(): string;

    /**
     * @param string $supplierId
     */
    public function setSupplierId(string $supplierId): void;

    /**
     * @return string
     */
    public function getSupplierAuxId(): string;

    /**
     * @param string $supplierAuxId
     */
    public function setSupplierAuxId(string $supplierAuxId): void;

    /**
     * @return string
     */
    public function getUnitPrice(): string;

    /**
     * @param string $unitPrice
     */
    public function setUnitPrice(string $unitPrice): void;

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
    public function getDescription(): string;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @return string
     */
    public function getUom(): string;

    /**
     * @param string $uom
     */
    public function setUom(string $uom): void;

    /**
     * @return string
     */
    public function getComments(): string;

    /**
     * @param string $comments
     */
    public function setComments(string $comments): void;

    /**
     * @return string
     */
    public function getSessionKey(): string;

    /**
     * @param string $sessionKey
     */
    public function setSessionKey(string $sessionKey): void;

    /**
     * @return string
     */
    public function getCartPosition(): string;

    /**
     * @param string $cartPosition
     */
    public function setCartPosition(string $cartPosition): void;

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int;

    /**
     * @return int
     */
    public function getMagentoItemId(): int;
}
