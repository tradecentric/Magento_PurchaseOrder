<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Punchout2Go\PurchaseOrder\Model\Carrier\OrderRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;

/**
 * Class OrderRequestTest
 * @package Punchout2Go\PurchaseOrder\Test\Unit\Model\Carrier
 */
class OrderRequestTest extends TestCase
{
    const CODE = 'orderrequest';

    protected $model;

    protected $scope;

    protected function setUp(): void
    {
        $this->scope = $this->createMock(ScopeConfigInterface::class);
        $errorFactory = $this->createStub(ErrorFactory::class);
        $rateFactory = $this->createStub(ResultFactory::class);
        $rateFactory->method('create')->willReturn(
            new Result($this->createStub(StoreManagerInterface::class))
        );

        $priceCurrency = $this->createStub(PriceCurrencyInterface::class);
        $priceCurrency->method('round')->willReturnArgument(0);
        $methodFactory = $this->createStub(MethodFactory::class);
        $methodFactory->method('create')->willReturn(new Method($priceCurrency));

        $this->model = new OrderRequest(
            $this->scope,
            $errorFactory,
            $rateFactory,
            $methodFactory,
            $this->createStub(LoggerInterface::class)
        );
    }

    /**
     * Callback function, emulates getValue function.
     *
     * @param string $path
     * @return null|string
     */
    public function scopeConfigGetValue(string $path)
    {
        $pathMap = [
            'carriers/'. OrderRequest::CODE . '/active' => true,
            'carriers/'. OrderRequest::CODE . '/title' => 'Order Request Title',
            'carriers/'. OrderRequest::CODE . '/name' => 'Order Request Name',
            'carriers/'. OrderRequest::CODE . '/price' => '666'
        ];

        return $pathMap[$path] ?? null;
    }

    public function testCollectRatesDisabled()
    {
        $this->scope->expects($this->once())->method('isSetFlag')
            ->with('carriers/'. OrderRequest::CODE . '/active')
            ->willReturn(false);
        $this->assertFalse($this->model->collectRates(new RateRequest()));
    }

    public function testCollectRates()
    {
        $this->scope->expects($this->once())->method('isSetFlag')->willReturn(true);
        $this->scope->method('getValue')
            ->willReturnCallback([$this, 'scopeConfigGetValue']);
        /** @var Result $result */
        $result = $this->model->collectRates(new RateRequest());
        $rates = $result->getAllRates();
        $this->assertNotEmpty($rates);
        $rate = current($rates);
        $this->assertEquals(666, $rate->getPrice());
        $this->assertEquals('Order Request Title', $rate->getCarrierTitle());
        $this->assertEquals(OrderRequest::CODE, $rate->getCarrier());
        $this->assertEquals('Order Request Name', $rate->getMethodTitle());
        $this->assertEquals(OrderRequest::CODE, $rate->getMethod());
    }
}
