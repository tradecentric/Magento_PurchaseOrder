<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PurchaseOrderItem
 * @package Punchout2Go\PurchaseOrder\Model\ResourceModel
 */
class PurchaseOrderItem extends AbstractDb
{
    /**
     * @var string
     */
    protected $connectionName = 'sales';

    /**
     * @var array[]
     */
    protected $_serializableFields = ['extra_data' => ['', []]];

    /**
     * @var bool
     */
    protected $_isPkAutoIncrement = false;

    protected function _construct()
    {
        $this->_init('sales_order_item_purchase_order', 'item_id');
    }
}
