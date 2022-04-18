<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;

/**
 * Interface QuoteItemProcessorInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteItemProcessorInterface
{
    /**
     * @param CartInterface $quote
     * @param QuoteItemInterface $punchoutItem
     * @return CartItemInterface|null
     */
    public function addPunchoutQuoteItemToCart(CartInterface $quote, QuoteItemInterface $punchoutItem): ?CartItemInterface;
}
