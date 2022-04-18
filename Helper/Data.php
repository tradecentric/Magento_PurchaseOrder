<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_API_KEY = 'punchout2go_purchaseorder/authentication/api_key';
    const XML_PATH_ALLOW_REORDER = "punchout2go_purchaseorder/orders/allow_reorder";

    /**
     * @var string[]
     */
    protected $availableModes = ['test', 'development', 'production'];

    /**
     * @param null $storeId
     * @return mixed|string
     */
    public function getApiKey($storeId = null): string
    {
        $value = $this->scopeConfig->getValue(
            static::XML_PATH_API_KEY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return (bool) strlen($value) ? $value : '';
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isAllowedReorder($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_ALLOW_REORDER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return string[]
     */
    public function getAvailableModes()
    {
        return $this->availableModes;
    }
}
