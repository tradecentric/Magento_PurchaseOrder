<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\App\ProductMetadataInterface;
use Punchout2Go\PurchaseOrder\Api\ModuleMetadataInterface;

/**
 * Class ModuleMetadata
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ModuleMetadata implements ModuleMetadataInterface
{
    /**
     * @var ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var ModuleVersion
     */
    protected $moduleVersion;

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @param ProductMetadataInterface $productMetadata
     * @param ModuleVersion $moduleVersion
     * @param string $moduleName
     */
    public function __construct(
        ProductMetadataInterface $productMetadata,
        ModuleVersion $moduleVersion,
        string $moduleName = 'Punchout2Go_PurchaseOrder'
    ) {
        $this->productMetadata = $productMetadata;
        $this->moduleVersion = $moduleVersion;
        $this->moduleName = $moduleName;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    /**
     * @return string
     */
    public function getModuleVersion(): string
    {
        return $this->moduleVersion->getModuleVersion($this->moduleName);
    }

    /**
     * @return string
     */
    public function getMagentoVersion(): string
    {
        return $this->productMetadata->getVersion();
    }
}
