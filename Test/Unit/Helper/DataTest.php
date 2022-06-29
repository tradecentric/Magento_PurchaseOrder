<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Helper;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class DataTest
 * @package Punchout2Go\PurchaseOrder\Test\Unit\Helper
 */
class DataTest extends TestCase
{
    protected $context;

    protected $scopeConfig;

    protected $helper;

    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMockForAbstractClass();

        $this->context->expects($this->any())
            ->method('getScopeConfig')
            ->willReturn($this->scopeConfig);
        $this->helper = new Data(new Json(), $this->context);
    }

    public function testGetApiKey()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_API_KEY,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('test 123');
        $this->assertEquals('test 123', $this->helper->getApiKey());

    }

    public function testGetApiKeyEmpty()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_API_KEY,
            ScopeInterface::SCOPE_STORE,
            1
        )->willReturn('');
        $this->assertEquals('', $this->helper->getApiKey(1));
    }

    public function testIsAllowedReorder()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_ALLOW_REORDER,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(false);
        $this->assertFalse($this->helper->isAllowedReorder());
    }

    public function testIsItemsAvailabilityCheck()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_CHECK_AVAILABILITY,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(true);
        $this->assertTrue($this->helper->isItemsAvailabilityCheck());
    }

    public function testIsAllowedQtyEdit()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_IS_ALLOW_QTY_EDIT,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(true);
        $this->assertTrue($this->helper->isAllowedQtyEdit());
    }

    public function testIsAllowedUnitPriceEdit()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_ALLOW_PRICE_EDIT,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(true);
        $this->assertTrue($this->helper->isAllowedUnitPriceEdit());
    }

    public function testIsAllowedProvidedShipping()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_APPLY_SHIPPING,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(true);
        $this->assertTrue($this->helper->isAllowedProvidedShipping());
    }

    public function testGetShippingPolicy()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            1
        )->willReturn('{"test":"test"}');
        $this->assertEquals(['test' => 'test'], $this->helper->getShippingPolicy(1));
    }

    public function testGetShippingPolicyEmpty()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('');
        $this->assertEquals([], $this->helper->getShippingPolicy());
    }

    public function testGetShippingPolicyWrongString()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            2
        )->willReturn('{1234}');
        $this->assertEquals([], $this->helper->getShippingPolicy(2));
    }

    public function testGetDefaultShippingMethod()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            1
        )->willReturn('[{"shipping_policy":"method_carrier"}]');

        $this->assertEquals('method', $this->helper->getDefaultShippingMethod(1));
    }

    public function testGetDefaultShippingMethodEmptyString()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('');
        $this->assertEquals('', $this->helper->getDefaultShippingMethod());
    }

    public function testGetDefaultCarrierMethod()
    {

        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            1
        )->willReturn('[{"shipping_policy":"method_carrier"}]');
        $this->assertEquals('carrier', $this->helper->getDefaultCarrierMethod(1));
    }

    public function testGetDefaultCarrierMethodEmptyString()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_SHIPPING_POLICY,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('');
        $this->assertEquals('', $this->helper->getDefaultCarrierMethod());
    }

    public function testGetDefaultPaymentMethod()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_PAYMENT_METHOD,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('test 123');
        $this->assertEquals('test 123', $this->helper->getDefaultPaymentMethod());
    }

    public function testIsAllowedTaxes()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_APPLY_TAXES,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(false);
        $this->assertEquals(false, $this->helper->isAllowedTaxes());
    }

    public function testIsCustomerNotify()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_NOTIFY_CUSTOMER,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(false);
        $this->assertEquals(false, $this->helper->isCustomerNotify());
    }

    public function testGetOrderSuccessStatus()
    {
        $this->scopeConfig->expects($this->once())->method('getValue')->with(
            Data::XML_PATH_ORDER_SUCCESS_STATUS,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn('test 123');
        $this->assertEquals('test 123', $this->helper->getOrderSuccessStatus());
    }

    public function testIsLogging()
    {
        $this->scopeConfig->expects($this->once())->method('isSetFlag')->with(
            Data::XML_PATH_IS_LOGGING,
            ScopeInterface::SCOPE_STORE,
            null
        )->willReturn(true);
        $this->assertTrue($this->helper->isLogging());
    }
}
