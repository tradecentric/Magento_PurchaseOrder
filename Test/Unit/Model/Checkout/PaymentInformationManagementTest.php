<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Payment\Model\Checks\ZeroTotal;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Payment;
use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Model\Checkout\PaymentInformationManagement;

class PaymentInformationManagementTest extends TestCase
{
    protected $model;

    protected $zeroTotalValidator;

    protected function setUp(): void
    {
        $this->zeroTotalValidator = $this->createPartialMock(ZeroTotal::class, ['isApplicable']);
        $this->model = new PaymentInformationManagement($this->zeroTotalValidator);
    }

    public function testSavePaymentInformation()
    {
        $currentBillingAddressMock = $this->createPartialMock(Address::class, ['getCustomerId']);
        $currentBillingAddressMock->expects($this->once())->method('getCustomerId')->willReturn('123');

        $newBillingAddressMock = $this->createPartialMock(Address::class, ['setCustomerId', 'getCountryId']);
        $newBillingAddressMock->expects($this->once())->method('setCustomerId')->with('123');

        $rate = $this->getMockBuilder(Address\Rate::class)
            ->addMethods(['getCarrier'])
            ->disableOriginalConstructor()
            ->getMock();

        $rate->expects($this->once())->method('getCarrier')->willReturn('test_test');

        $shippingAddressMock = $this->getMockBuilder(Address::class)
            ->addMethods(['setLimitCarrier', 'setCollectShippingRates', 'setPaymentMethod'])
            ->onlyMethods(['getShippingMethod', 'getShippingRateByCode', 'getCountryId'])
            ->disableOriginalConstructor()
            ->getMock();
        $shippingAddressMock->expects($this->exactly(2))->method('getShippingMethod')->willReturn('test');
        $shippingAddressMock->expects($this->once())->method('getShippingRateByCode')->willReturn($rate);
        $shippingAddressMock->expects($this->once())->method('setLimitCarrier')->with('test_test');
        $shippingAddressMock->expects($this->once())->method('getCountryId')->willReturn('123');
        $shippingAddressMock->expects($this->once())->method('setCollectShippingRates')->with(true);

        $quoteMock = $this->getMockBuilder(Quote::class)
            ->addMethods(['setTotalsCollectedFlag'])
            ->onlyMethods(['getShippingAddress', 'setBillingAddress', 'setDataChanges', 'getBillingAddress', 'isVirtual', 'getPayment'])
            ->disableOriginalConstructor()
            ->getMock();
        $quoteMock->expects($this->once())->method('isVirtual')->willReturn(false);
        $quoteMock->expects($this->once())->method('setTotalsCollectedFlag')->with(false);
        $quoteMock->expects($this->once())->method('setBillingAddress')->with($newBillingAddressMock);
        $quoteMock->expects($this->once())->method('getBillingAddress')->willReturn($currentBillingAddressMock);
        $quoteMock->expects($this->exactly(2))->method('getShippingAddress')->willReturn($shippingAddressMock);
        $quoteMock->expects($this->once())->method('setDataChanges')->with(true);

        $currentPayment = $this->createPartialMock(Payment::class, ['importData', 'getData', 'getMethodInstance']);
        $paymentData = ['test1' => 'test1', 'test2' => 'test2', 'method' => 'test payment'];
        $paymentDataCallback = function(string $value = null) use ($paymentData) {
            return isset($paymentData[$value]) ? $paymentData[$value] : $paymentData;
        };
        $payment = $this->getMockBuilder(Payment::class)
            ->addMethods(['setChecks'])
            ->onlyMethods(['getData'])
            ->disableOriginalConstructor()
            ->getMock();
        $payment->expects($this->any())->method('getData')
            ->willReturnCallback($paymentDataCallback);

        $paymentInfo = $this->createMock(\Magento\Payment\Model\MethodInterface::class);

        $currentPayment->expects($this->once())->method('getMethodInstance')->willReturn($paymentInfo);
        $currentPayment->expects($this->once())->method('importData')->with($paymentData);
        $currentPayment->expects($this->any())->method('getData')->willReturnCallback($paymentDataCallback);
        $quoteMock->expects($this->once())->method('getPayment')->willReturn($currentPayment);
        $shippingAddressMock->expects($this->once())->method('setPaymentMethod')->with('test payment');
        $this->zeroTotalValidator->expects($this->once())
            ->method('isApplicable')
            ->with($paymentInfo, $quoteMock)
            ->willReturn(true);
        $this->assertTrue($this->model->savePaymentInformation($quoteMock, $payment, $newBillingAddressMock));

    }


    /*public function testSet()
    {

    }

    public function testSetVirtual()
    {

    }*/
}
