<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Tax\Model\Sales\Total\Quote\Tax;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Punchout2Go\PurchaseOrder\Api\TaxServiceInterface;

/**
 * Class TaxCollectorPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class TaxCollectorPlugin
{
    /**
     * @var TaxServiceInterface
     */
    protected $service;

    /**
     * TaxCollectorPlugin constructor.
     * @param TaxServiceInterface $service
     */
    public function __construct(TaxServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Tax $subject
     * @param Tax $result
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return Tax
     */
    public function afterCollect(
        Tax $subject,
        Tax $result,
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        if (!$shippingAssignment->getItems()) {
            return $result;
        }
        if ($quote->getExtensionAttributes()->getIsPurchaseOrder()) {
            $this->service->addCustomTaxesToTotals(
                $total,
                $subject->getCode(),
                (float) $quote->getExtensionAttributes()->getPurchaseOrderTax(),
                $quote->getStoreId()
            );
        }
        return $result;
    }
}
