<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface SalesServiceInterface
{
    /**
     * @param QuoteInterface $punchoutQuote
     * @return int
     */
    public function createOrder(QuoteInterface $punchoutQuote): int;

    /**
     * @param QuoteInterface $punchoutQuote
     * @return CartInterface
     */
    public function createQuote(QuoteInterface $punchoutQuote): CartInterface;
}
