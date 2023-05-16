<?php

namespace Punchout2Go\PurchaseOrder\Plugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Model\PunchoutQuote\ExtraAttribute;
use Punchout2Go\PurchaseOrder\Model\PunchoutQuote\QuoteItem;
use Punchout2Go\PurchaseOrder\Model\Service\PunchoutQuoteService;

class Tax extends \Magento\Weee\Model\ResourceModel\Tax
{
    /**
     * @var PunchoutQuoteService
     */
    protected $punchoutQuoteService;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        PunchoutQuoteService $punchoutQuoteService,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        Context $context,
        DateTime $dateTime,
        $connectionName = null
    )
    {
        $this->punchoutQuoteService = $punchoutQuoteService;
        $this->productRepository = $productRepository;
        parent::__construct($context, $dateTime, $connectionName);
    }

    public function afterFetchWeeeTaxCalculationsByEntity($subject, $result, $countryId, $regionId, $websiteId, $storeId, $entityId)
    {
        $punchoutQuote = $this->punchoutQuoteService->getPunchoutQuote();
        if (count($result) && $punchoutQuote) {
            try {
                $product = $this->productRepository->getById($entityId);
                /** @var QuoteItem $item */
                foreach ($punchoutQuote->getItems() as $item) {
                    if ($item->getSupplierId() !== $product->getSku()) continue;

                    /** @var ExtraAttribute $fixedProductTax */
                    foreach ($item->getFixedProductTax() as $fixedProductTax) {
                        foreach ($result as &$resultItem) {
                            if ($resultItem['attribute_code'] !== $fixedProductTax->getName()) continue;

                            $resultItem['weee_value'] = (float)$fixedProductTax->getValue();
                        }
                    }
                }
            } catch (\Exception $e) {}
        }

        return $result;
    }
}