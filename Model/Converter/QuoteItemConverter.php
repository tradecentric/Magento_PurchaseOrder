<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Converter;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Api\Data\CartItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteItemConverterInterface;

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
     * QuoteItemConverter constructor.
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
    public function toQuoteItem(QuoteItemInterface $item): CartItemInterface
    {
        /** @var \Magento\Quote\Api\Data\CartItemInterface $cartItem */
        $cartItem = $this->cartItemFactory->create();
        $cartItem->setItemId($item->getMagentoItemId());
        $cartItem->setQuoteId($item->getMagentoQuoteId());
        $cartItem->setSku($item->getSupplierId());
        $cartItem->setQty($item->getQuantity());
        $cartItem->setPrice($item->getUnitPrice());
        $cartItem->setName($item->getDescription());
        return $cartItem;
    }
}
