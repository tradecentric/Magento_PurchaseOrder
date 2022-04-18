<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface SalesServiceInterface
{
    /**
     * @param QuoteInterface $punchoutQuote
     * @return OrderInterface
     */
    public function createOrder(QuoteInterface $punchoutQuote): OrderInterface;

    /**
     * @param QuoteInterface $punchoutQuote
     * @return CartInterface
     */
    public function createQuote(QuoteInterface $punchoutQuote): CartInterface;
}
