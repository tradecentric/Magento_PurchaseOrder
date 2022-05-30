<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\System\Config\Backend;

/**
 * Backend for serialized array data
 */
class ShippingPolicy extends \Magento\Framework\App\Config\Value
{
    /**
     * @var null
     */
    protected $serialize = null;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Serialize\Serializer\Json $serialize
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->serialize = $serialize;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Process data after load
     *
     * @return void
     */
    protected function _afterLoad()
    {
        $value = $this->getValue() ?? '{}';
        try {
            $value = $this->serialize->unserialize($value);
        } catch (\Exception $e) {
            $value = [];
        }
        $this->setValue($value);
    }

    /**
     * Prepare data before save
     *
     * @return void
     */
    public function beforeSave()
    {
        $value = array_filter($this->getValue(), function($item) {
            return is_array($item);
        });
        $value =  $this->serialize->serialize($value);
        $this->setValue($value);
    }
}
