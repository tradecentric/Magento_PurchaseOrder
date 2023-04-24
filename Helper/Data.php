<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\Serializer\Json;

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
    const XML_PATH_PAYMENT_METHOD = "punchout2go_purchaseorder/orders/payment_method";
    const XML_PATH_APPLY_TAXES = "punchout2go_purchaseorder/orders/apply_provided_tax";
    const XML_PATH_NOTIFY_CUSTOMER = "punchout2go_purchaseorder/orders/notify_customer";
    const XML_PATH_ORDER_SUCCESS_STATUS = "punchout2go_purchaseorder/orders/successful_order_status";
    const XML_PATH_IS_LOGGING = "punchout2go_purchaseorder/system/logging";

    const SUPPLIER_ID_PATTERN = '/^([^\/]+)\/([^\/]+)$/';

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @param Json $serializer
     * @param Context $context
     */
    public function __construct(
        Json $serializer,
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
    public function isAllowedQtyEdit($storeId = null)
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
    public function isAllowedUnitPriceEdit($storeId = null)
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
    public function isAllowedProvidedShipping($storeId = null)
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

    /**
     * @param null $storeId
     * @return mixed|string
     */
    public function getDefaultShippingMethod($storeId = null)
    {
        $shipping = (string) current(array_column($this->getShippingPolicy($storeId), 'shipping_policy'));
        if (!strlen($shipping)) {
            return '';
        }
        list ($method,) = explode('_', $shipping);
        return $method;
    }

    /**
     * @param null $storeId
     * @return mixed|string
     */
    public function getDefaultCarrierMethod($storeId = null)
    {
        $shipping = (string) current(array_column($this->getShippingPolicy($storeId), 'shipping_policy'));
        if (!strlen($shipping)) {
            return '';
        }
        list (, $carrier) = explode('_', $shipping);
        return $carrier;
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getDefaultPaymentMethod($storeId = null)
    {
        return (string) $this->scopeConfig->getValue(
            static::XML_PATH_PAYMENT_METHOD,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isAllowedTaxes($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_APPLY_TAXES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isCustomerNotify($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_NOTIFY_CUSTOMER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getOrderSuccessStatus($storeId = null)
    {
        return (string) $this->scopeConfig->getValue(
            static::XML_PATH_ORDER_SUCCESS_STATUS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isLogging($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_IS_LOGGING,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public static function prepareTaxTotalName(string $title): string {
        return 'total_' . strtolower(str_replace(' ', '_', $title));
    }
}
