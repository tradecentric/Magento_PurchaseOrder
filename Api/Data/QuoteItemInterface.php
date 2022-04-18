<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
interface QuoteItemInterface
{
    /**
     * @return int
     */
    public function getLineNumber(): int;

    /**
     * @param int $lineNumber
     */
    public function setLineNumber(int $lineNumber): void;

    /**
     * @return string
     */
    public function getRequestedDeliveryDate(): string;

    /**
     * @param string $requestedDeliveryDate
     */
    public function setRequestedDeliveryDate(string $requestedDeliveryDate): void;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void;

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
     * @return float
     */
    public function getUnitPrice(): float;

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice(float $unitPrice): void;

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
     * @return int
     */
    public function getCartPosition(): int;

    /**
     * @param int $cartPosition
     */
    public function setCartPosition(int $cartPosition): void;

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int;

    /**
     * @return int
     */
    public function getMagentoItemId(): int;
}
