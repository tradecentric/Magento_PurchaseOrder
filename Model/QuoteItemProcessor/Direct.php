<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemConverterInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemProcessorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class Direct
 * @package Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor
 */
class Direct implements QuoteItemProcessorInterface
{
    /**
     * @var QuoteItemConverterInterface
     */
    protected $quoteItemConverter;

    /**
     * @var ProductRepositoryInterface
     */
    protected $availabilityChecker;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Direct constructor.
     * @param QuoteItemConverterInterface $quoteItemConverter
     * @param ProductAvailabilityChecker $availabilityChecker
     * @param Data $helper
     */
    public function __construct(
        QuoteItemConverterInterface $quoteItemConverter,
        ProductAvailabilityChecker $availabilityChecker,
        Data $helper
    ) {
        $this->quoteItemConverter = $quoteItemConverter;
        $this->availabilityChecker = $availabilityChecker;
        $this->helper = $helper;
    }

    /**
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface|null
     * @throws LocalizedException
     */
    public function addPunchoutQuoteItemToCart(
        CartInterface $quote,
        QuoteItemInterface $punchoutItem
    ): ?CartItemInterface {
        if (!$quote->getDirectLoad()) {
            return null;
        }
        $quoteItem = $this->quoteItemConverter->toQuoteItem($punchoutItem);
        $magentoQuoteItem = $quote->getItemById($quoteItem->getItemId());
        if (!$magentoQuoteItem) {
            return null;
        }
        $product = $magentoQuoteItem->getProduct();
        if (!$this->availabilityChecker->isProductAvailabile($product, $quote->getStoreId())) {
            __("Product is not available : {$product->getName()} {$product->getSku()}");
        }
        $magentoQuoteItem->isDeleted(false);
        if ($quoteItem->getQty() == $magentoQuoteItem->getQty()) {
            return $magentoQuoteItem;
        }
        if ($this->helper->isAllowQtyEdit($quote->getStoreId())) {
            $magentoQuoteItem->setQty($quoteItem->getQty());
            return $magentoQuoteItem;
        }
        throw new LocalizedException(__("Line item qty modification on %1 %2 ", $magentoQuoteItem->getName(), $magentoQuoteItem->getSku()));
    }
}
