<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderItemInterface;

/**
 * Class OrderQuoteLineNumber
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PurchaseOrderItem extends AbstractModel implements PurchaseOrderItemInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderItem::class);
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return (string) $this->getData(static::ITEM_ID);
    }

    /**
     * @param string $itemId
     * @return PurchaseOrderItemInterface
     */
    public function setItemId(string $itemId): PurchaseOrderItemInterface
    {
        $this->setData(static::ITEM_ID, $itemId);
        return $this;
    }

    /**
     * @return string
     */
    public function getLineNumber(): string
    {
        return (string) $this->getData(static::LINE_NUMBER);
    }

    /**
     * @param string $lineNumber
     * @return PurchaseOrderItemInterface
     */
    public function setLineNumber(string $lineNumber): PurchaseOrderItemInterface
    {
        $this->setData(static::LINE_NUMBER, $lineNumber);
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderRequestId(): string
    {
        return (string) $this->getData(static::ORDER_REQUEST_ID);
    }

    /**
     * @param string $requestId
     * @return PurchaseOrderItemInterface
     */
    public function setOrderRequestId(string $requestId): PurchaseOrderItemInterface
    {
        $this->setData(static::ORDER_REQUEST_ID, $requestId);
        return $this;
    }

    /**
     * @return string
     */
    public function getPoNumber(): string
    {
        return (string) $this->getData(static::PO_NUMBER);
    }

    /**
     * @param string $poNumber
     * @return PurchaseOrderItemInterface
     */
    public function setPoNumber(string $poNumber): PurchaseOrderItemInterface
    {
        $this->setData(static::PO_NUMBER, $poNumber);
        return $this;
    }
}