<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\OrderItemSearchResultInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderItemInterface;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderItem;

/**
 * Class OrderItemRepositoryPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class OrderItemRepositoryPlugin
{
    /**
     * @var PurchaseOrderItem
     */
    protected $resource;

    /**
     * @var OrderLineNumberInterfaceFactory
     */
    protected $factory;

    /**
     * @param PurchaseOrderItem $resource
     * @param PurchaseOrderItemInterfaceFactory $factory
     */
    public function __construct(
        PurchaseOrderItem               $resource,
        PurchaseOrderItemInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @param OrderItemRepositoryInterface $subject
     * @param OrderItemInterface $result
     * @return OrderItemInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function afterSave(
        OrderItemRepositoryInterface $subject,
        OrderItemInterface $result
    ) {
        if ($result->isDeleted()) {
            return $result;
        }
        /** @var PurchaseOrderItemInterface $item */
        $item = $this->factory->create();
        $item->setItemId((string) $result->getId());
        $item->setLineNumber((string) $result->getExtensionAttributes()->getLineNumber());
        $item->setOrderRequestId((string) $result->getExtensionAttributes()->getOrderRequestId());
        $item->setPoNumber((string) $result->getExtensionAttributes()->getPoNumber());
        $item->setExtraData((array) $result->getExtensionAttributes()->getExtraData());
        $this->resource->save($item);
        return $result;
    }

    /**
     * @param OrderItemRepositoryInterface $subject
     * @param OrderItemSearchResultInterface $result
     * @return OrderItemSearchResultInterface
     */
    public function afterGetList(
        OrderItemRepositoryInterface $subject,
        OrderItemSearchResultInterface $result
    ) {
        foreach ($result->getItems() as $item) {
            /** @var PurchaseOrderItemInterface $instance */
            $instance = $this->factory->create();
            $this->resource->load($instance, $item->getId());
            $item->getExtensionAttributes()->setLineNumber($instance->getLineNumber());
            $item->getExtensionAttributes()->setOrderRequestId($instance->getOrderRequestId());
            $item->getExtensionAttributes()->setPoNumber($instance->getPoNumber());
            $item->getExtensionAttributes()->setExtraData((array) $instance->getExtraData());
        }
        return $result;
    }
}
