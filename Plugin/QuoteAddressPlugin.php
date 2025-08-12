<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Punchout2Go\PurchaseOrder\Api\ShippingServiceInterface;
use Punchout2Go\PurchaseOrder\Model\Carrier\OrderRequest;

/**
 * Class QuoteAddressPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class QuoteAddressPlugin
{
    /**
     * @var ShippingServiceInterface
     */
    protected $shippingService;

    /**
     * QuoteAddressPlugin constructor.
     * @param ShippingServiceInterface $shippingService
     */
    public function __construct(ShippingServiceInterface $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * @param Address $subject
     * @param bool $result
     * @return bool
     */
    public function afterRequestShippingRates(
        Address $subject,
        bool $result,
        ?AbstractItem $item = null
    ) {
        $quote = $subject->getQuote();
        if (!$quote) {
            return $result;
        }
        if ($quote->getExtensionAttributes()->getIsPurchaseOrder()) {
            if (!$subject->getShippingMethod()) {
                return $result;
            }
            $this->shippingService->setCustomPriceForShippingMethod(
                $subject,
                $subject->getShippingMethod(),
                (float) $quote->getExtensionAttributes()->getPurchaseOrderShippingPrice()
            );
            return $result;
        }
        $cleaned = $this->shippingService->deleteShippingForNonPurchaseOrderEntities(
            $subject,
            OrderRequest::CODE . '_' . OrderRequest::CODE,
            $item
        );
        return $cleaned ? false : $result;
    }
}
