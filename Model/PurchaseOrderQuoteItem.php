<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterface;

/**
 * Class PurchaseOrderQuoteItem
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PurchaseOrderQuoteItem extends AbstractModel implements PurchaseOrderQuoteItemInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderQuoteItem::class);
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
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setItemId(string $itemId): PurchaseOrderQuoteItemInterface
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
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setLineNumber(string $lineNumber): PurchaseOrderQuoteItemInterface
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
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setOrderRequestId(string $requestId): PurchaseOrderQuoteItemInterface
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
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setPoNumber(string $poNumber): PurchaseOrderQuoteItemInterface
    {
        $this->setData(static::PO_NUMBER, $poNumber);
        return $this;
    }

    /**
     * @param array $extraData
     * @return PurchaseOrderQuoteItemInterface
     */
    public function setExtraData(array $extraData): PurchaseOrderQuoteItemInterface
    {
        $this->setData(static::EXTRA_DATA, $extraData);
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraData(): array
    {
        return (array) $this->getData(static::EXTRA_DATA);
    }
}
