<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemConverterInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ItemsHandler
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class ItemsHandler implements QuoteElementHandlerInterface
{
    /**
     * @var QuoteItemConverterInterface
     */
    protected $quoteItemConverter;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @param QuoteItemConverterInterface $quoteItemConverter
     * @param ProductRepositoryInterface $productRepository
     * @param Data $helper
     */
    public function __construct(
        QuoteItemConverterInterface $quoteItemConverter,
        ProductRepositoryInterface $productRepository,
        CartRepositoryInterface $cartRepository,
        Data $helper
    ) {
        $this->quoteItemConverter = $quoteItemConverter;
        $this->productRepository = $productRepository;
        $this->helper = $helper;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param QuoteBuildContainerInterface $builder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $builder, PunchoutQuoteInterface $punchoutQuote): void
    {
        $quote = $this->cartRepository->get($punchoutQuote->getMagentoQuoteId());
        $quoteItems = $quote->getAllItems();

        foreach ($punchoutQuote->getItems() as $punchoutItem) {
            $oldItem = array_filter($quoteItems, function ($obj) use ($punchoutItem) {
                return $obj->getId() == $punchoutItem->getMagentoItemId();
            });

            if (is_array($oldItem)) $oldItem = end($oldItem);

            if ($oldItem->getSku() === $punchoutItem->getSupplierId()) {
                /** @var CartItemInterface $quoteItem */
                $product = $this->getQuoteItemFromProductId((int)$oldItem->getProductId());
            } else {
                /** @var CartItemInterface $quoteItem */
                $product = $this->getQuoteItemFromProductSku($punchoutItem->getSupplierId());
            }

            $quoteItem = $this->quoteItemConverter->toQuoteItem($punchoutItem, $product);
            if (!$quoteItem->getWeight() && $product) {
                $quoteItem->setWeight($product->getWeight());
                if ($quoteItem->getParentItem()) {
                    $currentWeight = $quoteItem->getParentItem()->getWeight();
                    $quoteItem->getParentItem()->setWeight($currentWeight + $product->getWeight());
                }
            }
            $builder->addItem($quoteItem);
        }
    }

    /**
     * @param int $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    protected function getQuoteItemFromProductId(int $productId) {
        return $this->productRepository->getById($productId);
    }

    /**
     * @param string $productSku
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    protected function getQuoteItemFromProductSku(string $productSku)
    {
        return $this->productRepository->get($productSku);
    }
}
