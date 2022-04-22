<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteConverterInterface;

/**
 * Class QuoteConverterPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteConverterPlugin
{
    /**
     * @param QuoteConverterInterface $subject
     * @param CartInterface $result
     * @param QuoteInterface $quote
     * @return CartInterface
     */
    public function afterToQuote(
        QuoteConverterInterface $subject,
        CartInterface $result,
        QuoteInterface $quote
    ) {
        $result->getExtensionAttributes()->setIsPurchaseOrder(1);
        return $result;
    }
}
