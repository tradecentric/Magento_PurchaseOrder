<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Api\Data\CartItemInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Model\Converter\QuoteItemConverter;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface;

/**
 * Class QuoteItemConverterPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteItemConverterPlugin
{
    /**
     * @param QuoteItemConverter $subject
     * @param CartItemInterface $result
     * @param QuoteItemInterface $item
     * @return CartItemInterface
     */
    public function afterToQuoteItem(
        QuoteItemConverter $subject,
        CartItemInterface $result,
        QuoteItemInterface $item
    ) {
        $result->getExtensionAttributes()
            ->setLineNumber((string) $item->getLineNumber())
            ->setExtraData($this->getExtraData($item));
        return $result;
    }

    /**
     * @param QuoteItemInterface $item
     * @return mixed[]
     */
    private function getExtraData(QuoteItemInterface $item)
    {
        $extensionAttributes = [];
        foreach ($item->getExtraData() as $attribute) {
            $extensionAttributes[$attribute->getName()] = $attribute->getValue();
        }
        return $extensionAttributes;
    }
}
