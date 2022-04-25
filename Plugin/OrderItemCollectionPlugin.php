<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Sales\Model\ResourceModel\Order\Item\Collection;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderItem;

/**
 * Class OrderItemCollectionPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class OrderItemCollectionPlugin
{
    /**
     * @var PurchaseOrderItem
     */
    protected $resource;

    /**
     * @var PurchaseOrderItemInterfaceFactory
     */
    protected $factory;

    /**
     * @param PurchaseOrderItem $resource
     * @param PurchaseOrderItemInterfaceFactory $factory
     */
    public function __construct(
        PurchaseOrderItem $resource,
        PurchaseOrderItemInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @param Collection $subject
     * @param Collection $result
     * @return Collection
     */
    public function afterLoadWithFilter(Collection $subject, Collection $result)
    {
        foreach ($subject as $item) {
            $instance = $this->factory->create();
            $this->resource->load($instance, $item->getId());
            $item->getExtensionAttributes()->setLineNumber($instance->getLineNumber());
            $item->getExtensionAttributes()->setOrderRequestId($instance->getOrderRequestId());
            $item->getExtensionAttributes()->setPoNumber($instance->getPoNumber());
        }
        return $result;
    }

    /**
     * @param Collection $subject
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function afterSave(Collection $subject, $result)
    {
        foreach ($subject->getItems() as $item) {
            if ($item->isDeleted()) {
                continue;
            }
            $object = $this->factory->create();
            $object->setItemId((string) $item->getId());
            $object->setLineNumber((string) $item->getExtensionAttributes()->getLineNumber());
            $object->setOrderRequestId((string) $item->getExtensionAttributes()->getOrderRequestId());
            $object->setPoNumber((string) $item->getExtensionAttributes()->getPoNumber());
            $this->resource->save($object);
        }
        return $result;
    }
}
