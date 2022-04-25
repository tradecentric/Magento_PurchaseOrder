<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Model\ResourceModel\Quote\Item\Collection;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderQuoteItem;

/**
 * Class QuoteItemCollectionPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteItemCollectionPlugin
{
    /**
     * @var PurchaseOrderQuoteItem
     */
    protected $resource;

    /**
     * @var PurchaseOrderQuoteItemInterfaceFactory
     */
    protected $factory;

    /**
     * @param PurchaseOrderQuoteItem $resource
     * @param PurchaseOrderQuoteItemInterfaceFactory $factory
     */
    public function __construct(
        PurchaseOrderQuoteItem $resource,
        PurchaseOrderQuoteItemInterfaceFactory $factory
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
