<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteConverterInterface
{
    /**
     * @param PunchoutQuoteInterface $item
     * @return CartInterface
     */
    public function toQuote(PunchoutQuoteInterface $item): CartInterface;
}
