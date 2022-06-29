<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Checkout;

use Magento\Checkout\Model\Type\Onepage;
use Magento\Customer\Api\Data\GroupInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Payment;
use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Model\Order;
use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Model\Checkout\CartManagement;
use Magento\Quote\Api\CartManagementInterface;

class CartManagementTest extends TestCase
{
    protected $model;

    protected $magentoCartManagement;

    protected $quoteMock;

    protected $eventManager;

    protected function setUp(): void
    {
        $this->eventManager = $this->getMockForAbstractClass(ManagerInterface::class);
        $this->magentoCartManagement = $this->createPartialMock(QuoteManagement::class, ['submit']);

        $this->model = new CartManagement(
            $this->magentoCartManagement,
            $this->eventManager
        );

        $this->quoteMock = $this->getMockBuilder(Quote::class)
            ->addMethods(['setCustomerEmail', 'setCustomerGroupId', 'setCustomerId'])
            ->onlyMethods(
                [
                    'collectTotals',
                    'getBillingAddress',
                    'getCheckoutMethod',
                    'getPayment',
                    'setCustomerIsGuest',
                    'getCustomer'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testPlaceOrderForQuoteNoPayment()
    {
        $email = 'email@mail.com';
        $firstname = 'test1';
        $lastname = 'test2';
        $middlename = 'test3';

        $this->quoteMock->expects($this->once())->method('collectTotals')->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('getCheckoutMethod')->willReturn(CartManagementInterface::METHOD_GUEST);
        $customerMock = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->quoteMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn($customerMock);

        $addressMock = $this->createPartialMock(Address::class, ['getEmail', 'getFirstname', 'getLastname', 'getMiddlename']);
        $addressMock->expects($this->once())->method('getEmail')->willReturn($email);
        $addressMock->expects($this->once())->method('getFirstname')->willReturn($firstname);
        $addressMock->expects($this->once())->method('getLastname')->willReturn($lastname);
        $addressMock->expects($this->once())->method('getMiddlename')->willReturn($middlename);


        $this->quoteMock->expects($this->any())->method('getBillingAddress')->with()->willReturn($addressMock);

        $this->quoteMock->expects($this->once())->method('setCustomerId')->with(null)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerEmail')->with($email)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerGroupId')->with(GroupInterface::NOT_LOGGED_IN_ID)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerIsGuest')->with(true)->willReturnSelf();

        $orderMock = $this->createPartialMock(
            Order::class,
            ['getId', 'getIncrementId', 'getStatus']
        );

        $this->magentoCartManagement->expects($this->once())->method('submit')->with($this->quoteMock)->willReturn($orderMock);

        $this->assertSame($orderMock, $this->model->placeOrderForQuote($this->quoteMock));
    }

    public function testPlaceOrderForQuoteOrderEmpty()
    {
        $email = 'email@mail.com';
        $firstname = 'test1';
        $lastname = 'test2';
        $middlename = 'test3';

        $this->quoteMock->expects($this->once())->method('collectTotals')->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('getCheckoutMethod')->willReturn(CartManagementInterface::METHOD_GUEST);
        $customerMock = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->quoteMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn($customerMock);

        $addressMock = $this->createPartialMock(Address::class, ['getEmail', 'getFirstname', 'getLastname', 'getMiddlename']);
        $addressMock->expects($this->once())->method('getEmail')->willReturn($email);
        $addressMock->expects($this->once())->method('getFirstname')->willReturn($firstname);
        $addressMock->expects($this->once())->method('getLastname')->willReturn($lastname);
        $addressMock->expects($this->once())->method('getMiddlename')->willReturn($middlename);


        $this->quoteMock->expects($this->any())->method('getBillingAddress')->with()->willReturn($addressMock);

        $this->quoteMock->expects($this->once())->method('setCustomerId')->with(null)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerEmail')->with($email)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerGroupId')->with(GroupInterface::NOT_LOGGED_IN_ID)->willReturnSelf();
        $this->quoteMock->expects($this->once())->method('setCustomerIsGuest')->with(true)->willReturnSelf();

        $this->magentoCartManagement->expects($this->once())->method('submit')->with($this->quoteMock)->willReturn(null);

        $this->expectException(LocalizedException::class);
        $this->model->placeOrderForQuote($this->quoteMock);
    }

    public function testPlaceOrder()
    {
        $quotePayment = $this->createMock(Payment::class);
        $quotePayment->expects($this->once())
            ->method('setQuote');
        $quotePayment->expects($this->once())
            ->method('importData');
        $this->quoteMock->expects($this->atLeastOnce())
            ->method('getPayment')
            ->willReturn($quotePayment);

        $this->quoteMock->expects($this->never())
            ->method('collectTotals');

        $this->quoteMock->expects($this->once())
            ->method('getCheckoutMethod')
            ->willReturn(Onepage::METHOD_CUSTOMER);

        $this->quoteMock->expects($this->never())
            ->method('setCustomerIsGuest')
            ->with(true);
        $this->quoteMock->expects($this->never())
            ->method('setCustomerGroupId')
            ->with(GroupInterface::NOT_LOGGED_IN_ID);

        $paymentMethod = $this->getMockBuilder(Payment::class)
            ->addMethods(['setChecks'])
            ->onlyMethods(['getData'])
            ->disableOriginalConstructor()
            ->getMock();
        $paymentMethod->expects($this->once())->method('setChecks');
        $paymentMethod->expects($this->once())->method('getData')->willReturn(['additional_data' => []]);

        $orderMock = $this->createMock(Order::class);

        $this->magentoCartManagement->expects($this->once())->method('submit')->willReturn($orderMock);

        $this->assertSame($orderMock, $this->model->placeOrderForQuote($this->quoteMock, $paymentMethod));
    }

}
