<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * Interface PurchaseOrderQuoteItemInterface
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface PurchaseOrderQuoteItemInterface
{
    const PO_NUMBER = 'po_number';
    const ORDER_REQUEST_ID = 'order_request_id';
    const LINE_NUMBER = 'line_number';
    const ITEM_ID = 'item_id';
    const EXTRA_DATA = 'extra_data';

    /**
     * @return string
     */
    public function getItemId(): string;

    /**
     * @param string $itemId
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setItemId(string $itemId): PurchaseOrderQuoteItemInterface;

    /**
     * @return string
     */
    public function getLineNumber(): string;

    /**
     * @param string $lineNumber
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setLineNumber(string $lineNumber): PurchaseOrderQuoteItemInterface;

    /**
     * @return string
     */
    public function getOrderRequestId(): string;

    /**
     * @param string $requestId
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setOrderRequestId(string $requestId): PurchaseOrderQuoteItemInterface;

    /**
     * @return string
     */
    public function getPoNumber(): string;

    /**
     * @param string $poNumber
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setPoNumber(string $poNumber): PurchaseOrderQuoteItemInterface;

    /**
     * @return mixed[]
     */
    public function getExtraData(): array;

    /**
     * @param array $extraData
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setExtraData(array $extraData): PurchaseOrderQuoteItemInterface;
}
