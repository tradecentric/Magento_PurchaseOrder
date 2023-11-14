<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Model\ResourceModel\Quote\Item\Collection;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderQuoteItem;
use Punchout2Go\Punchout\Api\SessionInterface;

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
     * @var SessionInterface
     */
    protected $punchoutSession;

    /**
     * @param PurchaseOrderQuoteItem $resource
     * @param PurchaseOrderQuoteItemInterfaceFactory $factory
     */
    public function __construct(
        PurchaseOrderQuoteItem $resource,
        PurchaseOrderQuoteItemInterfaceFactory $factory,
        SessionInterface $punchoutSession
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->punchoutSession = $punchoutSession;
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
            $item->getExtensionAttributes()->setExtraData($instance->getExtraData());
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
            if ($item->isDeleted() || !$this->punchoutSession->isValid()) {
                continue;
            }

            if (
                $item->getId() && (
                $item->getExtensionAttributes()->getLineNumber() ||
                $item->getExtensionAttributes()->getOrderRequestId() ||
                $item->getExtensionAttributes()->getPoNumber() ||
                $item->getExtensionAttributes()->getExtraData()
                )
            ) {
                $object = $this->factory->create();
                $object->setItemId((string) $item->getId());
                $object->setLineNumber((string) $item->getExtensionAttributes()->getLineNumber());
                $object->setOrderRequestId((string) $item->getExtensionAttributes()->getOrderRequestId());
                $object->setPoNumber((string) $item->getExtensionAttributes()->getPoNumber());
                $object->setExtraData((array) $item->getExtensionAttributes()->getExtraData());
                $this->resource->save($object);
            }
        }
        return $result;
    }
}
