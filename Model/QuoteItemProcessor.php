<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemProcessorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class QuoteItemProcessor
 * @package Punchout2Go\PurchaseOrder\Model
 */
class QuoteItemProcessor implements QuoteItemProcessorInterface
{
    /**
     * @var QuoteItemProcessorInterface[]
     */
    protected $quoteItemProcessors;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * QuoteItemProcessor constructor.
     * @param Data $helper
     * @param QuoteItemProcessorInterface[] $quoteItemProcessors
     */
    public function __construct(Data $helper, array $quoteItemProcessors = [])
    {
        $this->quoteItemProcessors = $quoteItemProcessors;
        $this->helper = $helper;
    }

    /**
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface|null
     */
    public function addPunchoutQuoteItemToCart(CartInterface $quote, QuoteItemInterface $punchoutItem): ?CartItemInterface
    {
        /** @var CartItemInterface $item */
        $item = $this->getQuoteItem($quote, $punchoutItem);
        if (!$item) {
            return null;
        }
        if ($this->helper->isAllowUnitPriceEdit($quote->getStoreId())) {
            $item->setCustomPrice($punchoutItem->getUnitPrice());
            $item->setOriginalCustomPrice($punchoutItem->getUnitPrice());
        }
        $item->setNoDiscount(1);
        $item->checkData();
        if (null != $item->getWeight()) {
            return $item;
        }
        $product = $item->getProduct();
        $item->setWeight($product->getWeight());
        if (!$item->getParentItem()) {
            return $item;
        }
        $currentWeight = $item->getParentItem()->getWeight();
        $item->getParentItem()->setWeight($currentWeight + $product->getWeight());
        return $item;
    }

    /**
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface|null
     */
    protected function getQuoteItem(CartInterface $quote, QuoteItemInterface $punchoutItem)
    {
        $item = null;
        foreach ($this->quoteItemProcessors as $itemProcessor) {
            if ($item = $this->processItem($itemProcessor, $quote, $punchoutItem)) {
                return $item;
            }
        }
        return $item;
    }

    /**
     * @param QuoteItemProcessorInterface $processor
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface|null
     */
    protected function processItem(QuoteItemProcessorInterface $processor, CartInterface $quote, QuoteItemInterface $punchoutItem)
    {
        return $processor->addPunchoutQuoteItemToCart($quote, $punchoutItem);
    }
}
