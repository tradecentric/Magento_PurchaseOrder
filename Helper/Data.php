<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\Serializer\Serialize;

/**
 * @package Punchout2Go\PurchaseOrder\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_API_KEY = 'punchout2go_purchaseorder/authentication/api_key';
    const XML_PATH_ALLOW_REORDER = "punchout2go_purchaseorder/orders/allow_reorder";
    const XML_PATH_CHECK_AVAILABILITY = "punchout2go_purchaseorder/orders/check_availability";
    const XML_PATH_IS_ALLOW_QTY_EDIT = "punchout2go_purchaseorder/orders/allow_qty_edits";
    const XML_PATH_ALLOW_PRICE_EDIT = "punchout2go_purchaseorders/orders/allow_unitprice_edits";
    const XML_PATH_APPLY_SHIPPING = "punchout2go_purchaseorder/orders/apply_provided_shipping";
    const XML_PATH_SHIPPING_POLICY = "punchout2go_purchaseorder/orders/shipping_policy";

    /**
     * @var Serialize
     */
    protected $serializer;

    /**
     * Data constructor.
     * @param Serialize $serializer
     * @param Context $context
     */
    public function __construct(
        Serialize $serializer,
        Context $context
    ) {
        $this->serializer = $serializer;
        parent::__construct($context);
    }

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
     * @param null $storeId
     * @return bool
     */
    public function isItemsAvailabilityCheck($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_CHECK_AVAILABILITY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isAllowQtyEdit($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_IS_ALLOW_QTY_EDIT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isAllowUnitPriceEdit($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_ALLOW_PRICE_EDIT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isAllowProvidedShipping($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_APPLY_SHIPPING,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return array
     */
    public function getShippingPolicy($storeId = null)
    {
        $value = (string) $this->scopeConfig->getValue(
            static::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        if (!strlen($value)) {
            return [];
        }
        try {
            return (array) $this->serializer->unserialize($value);
        } catch (\Exception $e) {
            return [];
        }
    }
}
