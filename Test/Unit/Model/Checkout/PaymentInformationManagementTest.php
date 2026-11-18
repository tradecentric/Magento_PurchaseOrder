<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Framework\DataObject;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Payment;
use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Model\Checkout\PaymentInformationManagement;

class PaymentInformationManagementTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        $this->model = new PaymentInformationManagement();
    }

    public function testSavePaymentInformation()
    {
        $currentBillingAddressMock = $this->createPartialMock(Address::class, ['getCustomerId']);
        $currentBillingAddressMock->expects($this->once())->method('getCustomerId')->willReturn('123');

        $newBillingAddressMock = $this->createPartialMock(Address::class, ['setCustomerId', 'getCountryId']);
        $newBillingAddressMock->expects($this->once())->method('setCustomerId')->with('123');

        $rate = new DataObject(['carrier' => 'test_test']);

        $shippingAddressMock = $this->getMockBuilder(AddressDouble::class)
            ->onlyMethods([
                'setLimitCarrier', 'setCollectShippingRates', 'setPaymentMethod',
                'getShippingMethod', 'getShippingRateByCode', 'getCountryId'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $shippingAddressMock->expects($this->exactly(2))->method('getShippingMethod')->willReturn('test');
        $shippingAddressMock->expects($this->once())->method('getShippingRateByCode')->willReturn($rate);
        $shippingAddressMock->expects($this->once())->method('setLimitCarrier')->with('test_test');
        $shippingAddressMock->expects($this->once())->method('getCountryId')->willReturn('123');
        $shippingAddressMock->expects($this->once())->method('setCollectShippingRates')->with(true);

        $quoteMock = $this->getMockBuilder(QuoteDouble::class)
            ->onlyMethods([
                'setTotalsCollectedFlag', 'getShippingAddress', 'setBillingAddress', 'setDataChanges',
                'getBillingAddress', 'isVirtual', 'getPayment'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $quoteMock->expects($this->once())->method('isVirtual')->willReturn(false);
        $quoteMock->expects($this->once())->method('setTotalsCollectedFlag')->with(false);
        $quoteMock->expects($this->once())->method('setBillingAddress')->with($newBillingAddressMock);
        $quoteMock->expects($this->once())->method('getBillingAddress')->willReturn($currentBillingAddressMock);
        $quoteMock->expects($this->exactly(2))->method('getShippingAddress')->willReturn($shippingAddressMock);
        $quoteMock->expects($this->once())->method('setDataChanges')->with(true);

        $currentPayment = $this->createPartialMock(Payment::class, ['importData', 'getMethod']);
        $paymentData = ['test1' => 'test1', 'test2' => 'test2', 'method' => 'test payment'];
        $payment = $this->createPartialMock(PaymentDouble::class, ['setChecks', 'getData']);
        $payment->expects($this->once())->method('setChecks')->with([
            \Magento\Payment\Model\MethodInterface::CHECK_USE_CHECKOUT,
            \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_COUNTRY,
            \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_CURRENCY,
            \Magento\Payment\Model\MethodInterface::CHECK_ORDER_TOTAL_MIN_MAX,
        ]);
        $payment->expects($this->once())->method('getData')->willReturn($paymentData);
        $currentPayment->expects($this->once())->method('importData')->with($paymentData);
        $currentPayment->expects($this->once())->method('getMethod')->willReturn('test payment');
        $quoteMock->expects($this->once())->method('getPayment')->willReturn($currentPayment);
        $shippingAddressMock->expects($this->once())->method('setPaymentMethod')->with('test payment');
        $this->assertTrue($this->model->savePaymentInformation($quoteMock, $payment, $newBillingAddressMock));

    }
}
