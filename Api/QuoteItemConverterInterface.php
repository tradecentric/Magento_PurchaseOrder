<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteItemConverterInterface
{
    /**
     * @param QuoteItemInterface $item
     * @return CartItemInterface
     */
    public function toQuoteItem(QuoteItemInterface $item, ProductInterface $product): CartItemInterface;
}
