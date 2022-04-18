<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor;

use Magento\Catalog\Api\Data\ProductInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ProductAvailabilityChecker
 * @package Punchout2Go\PurchaseOrder\Model\QuoteItemProcessor
 */
class ProductAvailabilityChecker
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ProductAvailabilityChecker constructor.
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param ProductInterface $product
     * @param $storeId
     * @return bool
     */
    public function isProductAvailabile(ProductInterface $product, $storeId)
    {
        if ($product->isAvailable()) {
            return true;
        }
        if (!$this->helper->isItemsAvailabilityCheck($storeId)) {
            return true;
        }
        return false;
    }
}
