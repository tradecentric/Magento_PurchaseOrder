<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * Interface PurchaseOrderItemInterface
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface PurchaseOrderItemInterface
{
    const PO_NUMBER = 'po_number';
    const ORDER_REQUEST_ID = 'order_request_id';
    const LINE_NUMBER = 'line_number';
    const ITEM_ID = 'item_id';
    const EXTRA_DATA = 'extra_data';
    const FIXED_PRODUCT_TAX = 'fixed_product_tax';

    /**
     * @return string
     */
    public function getItemId(): string;

    /**
     * @param int $itemId
     * @return PurchaseOrderItemInterface
     */
    public function setItemId(string $itemId): PurchaseOrderItemInterface;

    /**
     * @return string
     */
    public function getLineNumber(): string;

    /**
     * @param string $lineNumber
     * @return PurchaseOrderItemInterface
     */
    public function setLineNumber(string $lineNumber): PurchaseOrderItemInterface;

    /**
     * @return string
     */
    public function getOrderRequestId(): string;

    /**
     * @param string $requestId
     * @return PurchaseOrderItemInterface
     */
    public function setOrderRequestId(string $requestId): PurchaseOrderItemInterface;

    /**
     * @return string
     */
    public function getPoNumber(): string;

    /**
     * @param string $poNumber
     * @return PurchaseOrderItemInterface
     */
    public function setPoNumber(string $poNumber): PurchaseOrderItemInterface;

    /**
     * @return mixed[]
     */
    public function getExtraData(): array;

    /**
     * @param array $extraData
     * @return PurchaseOrderItemInterface
     */
    public function setExtraData(array $extraData): PurchaseOrderItemInterface;

    /**
     * @return mixed[]
     */
    public function getFixedProductTax(): array;

    /**
     * @param array $extraData
     * @return PurchaseOrderItemInterface
     */
    public function setFixedProductTax(array $fixedProductTax): PurchaseOrderItemInterface;
}
