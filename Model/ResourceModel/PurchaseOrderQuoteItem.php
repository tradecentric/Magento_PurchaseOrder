<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PurchaseOrderQuoteItem
 * @package Punchout2Go\PurchaseOrder\Model\ResourceModel
 */
class PurchaseOrderQuoteItem extends AbstractDb
{
    /**
     * @var string
     */
    protected $connectionName = 'checkout';

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
        $this->_init('quote_item_purchase_order', 'item_id');
    }
}
