<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Sales\Model\ResourceModel\Order\Item;

/**
 * Class ReorderHandler
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ReorderProvider
{
    /**
     * @var Item
     */
    protected $resourceModel;

    /**
     * @param Item $resourceModel
     */
    public function __construct(Item $resourceModel)
    {
        $this->resourceModel = $resourceModel;
    }

    /**
     * @param array $itemsId
     * @return mixed[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAlreadyOrderedItems(array $itemsId)
    {
        $connection = $this->resourceModel->getConnection();
        $select = $connection->select()
            ->from($this->resourceModel->getMainTable(), ['quote_item_id'])
            ->where('quote_item_id in (?)', $itemsId);
        return array_unique($connection->fetchCol($select));
    }
}
