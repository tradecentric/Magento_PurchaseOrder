<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Punchout2Go\PurchaseOrder\Model\Carrier\OrderRequest;

/**
 * Class QuoteAddressPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteAddressPlugin
{
    /**
     * @param Address $subject
     * @param bool $result
     * @return bool
     */
    public function afterRequestShippingRates(
        Address $subject,
        bool $result,
        AbstractItem $item = null
    ) {
        $quote = $subject->getQuote();
        if (!$quote || $quote->getExtensionAttributes()->getIsPurchaseOrder()) {
            return $result;
        }
        $rate = $subject->getShippingRateByCode(OrderRequest::CODE . '_' . OrderRequest::CODE);
        if (!$rate) {
            return $result;
        }
        $rate->isDeleted(true);
        if ($subject->getShippingMethod() !== $rate->getCode()) {
            return $result;
        }
        if ($item) {
            $item->unsBaseShippingAmount();
        } else {
            $this->unsShippingMethod()
                ->unsBaseShippingAmount()
                ->unsShippingAmount();
        }
        return false;
    }
}
