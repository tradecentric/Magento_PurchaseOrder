<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Error;
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

    protected $error;

    protected $errorFactory;


    protected function setUp(): void
    {
        $this->scope = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->error = $this->getMockBuilder(Error::class)
            ->setMethods(['setCarrier', 'setCarrierTitle', 'setErrorMessage'])
            ->getMock();

        $this->errorFactory = $this->getMockBuilder(ErrorFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->errorFactory->method('create')
            ->willReturn($this->error);

        $rate = $this->createPartialMock(Result::class, ['getError']);
        $rateFactory = $this->createPartialMock(ResultFactory::class, ['create']);

        $rateFactory->method('create')
            ->willReturn($rate);

        $methodFactory = $this->createPartialMock(MethodFactory::class, ['create']);
        $method = $this->createMock(Method::class);

        $rateFactory->method('create')
            ->willReturn($method);

        $this->model = new OrderRequest(
            $this->scope,
            $this->errorFactory,
            $rateFactory,
            $methodFactory,
            $this->getMockForAbstractClass(LoggerInterface::class)
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

    /**
     * @param RateRequest $request
     * @dataProvider rateRequestProvider
     */
    public function testCollectRatesDisabled(RateRequest $request)
    {
        $this->scope->method('isSetFlag')
            ->with('carriers/'. OrderRequest::CODE . '/active')
            ->willReturn(false);
        $this->assertFalse($this->model->collectRates($request));
    }

    /**
     * @param RateRequest $request
     * @dataProvider rateRequestProvider
     */
    public function testCollectRates(RateRequest $request)
    {
        $this->scope->method('getValue')
            ->willReturnCallback([$this, 'scopeConfigGetValue']);
        /** @var Result $result */
        $result = $this->model->collectRates($request);
        $rates = $result->getAllRates();
        $this->assertNotEmpty($rates);
        $rate = current($rates);
        $this->assertEquals(666, $rate->getPrice());
        $this->assertEquals('Order Request Title', $rate->getTitle());
        $this->assertEquals('Order Request Title', $rate->getCarrierTitle());
        $this->assertEquals(OrderRequest::CODE, $rate->getCarrier());
        $this->assertEquals('Order Request Name', $rate->getMethodTitle());
        $this->assertEquals(OrderRequest::CODE, $rate->getMethod());
    }

    /**
     * @return RateRequest
     */
    public function rateRequestProvider()
    {
        return new RateRequest();
    }
}
