<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface SalesServiceInterface
{
    /**
     * @param PunchoutQuoteInterface $punchoutQuote
     * @return int
     */
    public function createOrder(PunchoutQuoteInterface $punchoutQuote): int;

    /**
     * @param PunchoutQuoteInterface $punchoutQuote
     * @return CartInterface
     */
    public function createQuote(PunchoutQuoteInterface $punchoutQuote): CartInterface;
}
