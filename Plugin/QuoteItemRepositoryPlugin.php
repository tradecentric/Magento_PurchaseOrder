<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\Quote\Item\Repository;
use Punchout2Go\Punchout\Api\SessionInterface;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderQuoteItem;

/**
 * Class QuoteItemRepositoryPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteItemRepositoryPlugin
{
    /**
     * @var PurchaseOrderQuoteItem
     */
    protected $resource;

    /**
     * @var QuoteLineNumberInterfaceFactory
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
     * @param Repository $subject
     * @param CartItemInterface $result
     * @return CartItemInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function afterSave(
        Repository $subject,
        CartItemInterface $result
    ) {
        if ($result->isDeleted() || !$this->punchoutSession->isValid()) {
            return $result;
        }

        if (
            $result->getId() && (
            $result->getExtensionAttributes()->getOrderRequestId()||
            $result->getExtensionAttributes()->getLineNumber() ||
            $result->getExtensionAttributes()->getPoNumber()
            )
        ) {
            /** @var \Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterface $item */
            $item = $this->factory->create();
            $item->setEntityId($result->getId());
            $item->setOrderRequestId((string) $result->getExtensionAttributes()->getOrderRequestId());
            $item->setLineNumber((string) $result->getExtensionAttributes()->getLineNumber());
            $item->setPoNumber((string) $result->getExtensionAttributes()->getPoNumber());
            $this->resource->save($item);
        }

        return $result;
    }

    /**
     * @param Repository $subject
     * @param array $result
     * @return array
     */
    public function afterGetList(
        Repository $subject,
        array $result = []
    ) {
        foreach ($result as $item) {
            /** @var \Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterface $instance */
            $instance = $this->factory->create();
            $this->resource->load($instance, $item->getId());
            $item->getExtensionAttributes()->setLineNumber($instance->getLineNumber());
            $item->getExtensionAttributes()->setOrderRequestId($instance->getOrderRequestId());
            $item->getExtensionAttributes()->setPoNumber($instance->getPoNumber());
        }
        return $result;
    }
}
