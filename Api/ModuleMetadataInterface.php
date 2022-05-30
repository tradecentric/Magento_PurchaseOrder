<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * Interface ModuleMetadataInterface
 * @package TradeCentric\Invoice\Api
 */
interface ModuleMetadataInterface
{
    /**
     * @return string
     */
    public function getModuleVersion(): string;

    /**
     * @return string
     */
    public function getModuleName(): string;

    /**
     * @return string
     */
    public function getMagentoVersion(): string;
}
