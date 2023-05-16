<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Converter;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Api\Data\CartItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemConverterInterface;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Class QuoteItemConverter
 * @package Punchout2Go\PurchaseOrder\Model\Converter
 */
class QuoteItemConverter implements QuoteItemConverterInterface
{
    /**
     * @var CartItemInterfaceFactory
     */
    protected $cartItemFactory;

    /**
     * @param CartItemInterfaceFactory $cartItemFactory
     */
    public function __construct(
        CartItemInterfaceFactory $cartItemFactory
    ) {
        $this->cartItemFactory = $cartItemFactory;
    }

    /**
     * @param QuoteItemInterface $item
     * @return CartItemInterface
     */
    public function toQuoteItem(QuoteItemInterface $item, ProductInterface $product): CartItemInterface
    {
        foreach ($item->getFixedProductTax() as $fixedProductTax) {
            $productTaxes = $product->getData($fixedProductTax->getName());
            if ($productTaxes) {
                foreach ($productTaxes as &$productTax) {
                    $productTax['value'] = (float)$fixedProductTax->getValue();
                    $productTax['website_value'] = (float)$fixedProductTax->getValue();
                }

                $product->setData($fixedProductTax->getName(), $productTaxes);
            }
        }

        /** @var \Magento\Quote\Api\Data\CartItemInterface $cartItem */
        $cartItem = $this->cartItemFactory->create()
            ->setProduct($product)
            ->setItemId($item->getMagentoItemId())
            ->setQuoteId($item->getMagentoQuoteId())
            ->setSku($item->getSupplierId())
            ->setQty((int) $item->getQuantity())
            ->setCustomPrice((float) $item->getUnitPrice())
            ->setOriginalCustomPrice((float) $item->getUnitPrice())
            ->setPrice((float) $item->getUnitPrice())
            ->setName($item->getDescription());

        return $cartItem;
    }
}
