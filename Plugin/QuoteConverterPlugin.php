<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
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
     * @param PunchoutQuoteInterface $quote
     * @return CartInterface
     */
    public function afterToQuote(
        QuoteConverterInterface $subject,
        CartInterface $result,
        PunchoutQuoteInterface $quote
    ) {
        $result->getExtensionAttributes()->setIsPurchaseOrder(1);
        $result->getExtensionAttributes()->setPurchaseOrderTax($quote->getTax());
        $result->getExtensionAttributes()->setPurchaseOrderShippingPrice($quote->getShipping());
        $result->getExtensionAttributes()->setExtraData($quote->getExtraData());
        return $result;
    }
}
