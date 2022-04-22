<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteConverterInterface
{
    /**
     * @param QuoteInterface $item
     * @return CartInterface
     */
    public function toQuote(QuoteInterface $item): CartInterface;
}
