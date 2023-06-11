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

    /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    protected $attributeRepository;

    private $loadedAttributes = [];

    public function __construct(
        PunchoutQuoteService $punchoutQuoteService,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository,
        Context $context,
        DateTime $dateTime,
        $connectionName = null
    )
    {
        $this->punchoutQuoteService = $punchoutQuoteService;
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
        parent::__construct($context, $dateTime, $connectionName);
    }

    public function afterFetchWeeeTaxCalculationsByEntity($subject, $result, $countryId, $regionId, $websiteId, $storeId, $entityId)
    {
        $punchoutQuote = $this->punchoutQuoteService->getPunchoutQuote();
        if ($punchoutQuote) {
            $product = $this->productRepository->getById($entityId);
            /** @var QuoteItem $item */
            foreach ($punchoutQuote->getItems() as $item) {
                if ($item->getSupplierId() !== $product->getSku() && $product->getId() !== $item->getMagentoProductId()) continue;

                /** @var ExtraAttribute $fixedProductTax */
                foreach ($item->getFixedProductTax() as $fixedProductTax) {
                    $found = false;
                    foreach ($result as &$resultItem) {
                        if ($resultItem['attribute_code'] !== $fixedProductTax->getName()) continue;

                        $resultItem['weee_value'] = (float)$fixedProductTax->getValue();
                        $found = true;
                    }

                    if (!$found) {
                        $attributeData = $this->getAttributeData($fixedProductTax->getName());
                        $result[] = [
                            "attribute_code" => $attributeData['attribute_code'],
                            "label_value" => null,
                            "weee_value" => $fixedProductTax->getValue(),
                            "attribute_id" => $attributeData['attribute_id'],
                            "frontend_label" => $attributeData['frontend_label']
                        ];
                    }
                }
            }
        }

        return $result;
    }

    private function getAttributeData(string $code): array {
        if (!array_key_exists($code, $this->loadedAttributes)) {
            $attribute = $this->attributeRepository->get($code);
            $this->loadedAttributes[$code] = [
                "attribute_code" => $attribute->getAttributeCode(),
                "label_value" => null,
                "weee_value" => 0,
                "attribute_id" => $attribute->getId(),
                "frontend_label" => $attribute->getFrontendLabel()
            ];
        }

        return $this->loadedAttributes[$code];
    }
}

// [{"attribute_code":"fixed_product_tax","attribute_id":"158","frontend_label":"FPT","label_value":null,"weee_value":"10.0000"},{"attribute_code":"Recupei","attribute_id":"160","frontend_label":"recupei","label_value":null,"weee_value":"5.0000"}]
