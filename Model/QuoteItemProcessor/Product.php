<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemConverterInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemProcessorInterface;

/**
 * Class Direct
 * @package Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor
 */
class Product implements QuoteItemProcessorInterface
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
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Product constructor.
     * @param QuoteItemConverterInterface $quoteItemConverter
     * @param ProductAvailabilityChecker $availabilityChecker
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        QuoteItemConverterInterface $quoteItemConverter,
        ProductAvailabilityChecker $availabilityChecker,
        ProductRepositoryInterface $productRepository
    ) {
        $this->quoteItemConverter = $quoteItemConverter;
        $this->availabilityChecker = $availabilityChecker;
        $this->productRepository = $productRepository;
    }

    /**
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface
     * @throws LocalizedException
     */
    public function addPunchoutQuoteItemToCart(
        CartInterface $quote,
        QuoteItemInterface $punchoutItem
    ): ?CartItemInterface {
        $quoteItem = $this->quoteItemConverter->toQuoteItem($punchoutItem);
        $product = $this->getQuoteItemFromProductSku($quoteItem->getSku());
        if (!$product) {
            throw new LocalizedException(__("Failed to add a product to cart, product %1 doesnt exist", $quoteItem->getSku()));
        }
        if ($this->availabilityChecker->isProductAvailabile($product, $quote->getStoreId())) {
            throw new LocalizedException(
                __("Product is not available : %1 %2", $product->getName(), $product->getSku())
            );
        }
        return $quote->addProduct($product, $quoteItem->getQty());
    }

    /**
     * @param string $productSku
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    protected function getQuoteItemFromProductSku(string $productSku)
    {
        $product = null;
        try {
            $product = $this->productRepository->get($productSku);
        } catch (NoSuchEntityException $e) {}
        if (!$product & is_numeric($productSku)) {
            try {
                $product = $this->productRepository->getById((int) $productSku);
            } catch (NoSuchEntityException $e) {}
        }
        return $product;
    }
}
