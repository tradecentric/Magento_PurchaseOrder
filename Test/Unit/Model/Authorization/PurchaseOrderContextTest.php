<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Authorization;

use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Api\PunchoutContainerInterface;
use Punchout2Go\PurchaseOrder\Model\Authorization\PurchaseOrderContext;

class PurchaseOrderContextTest extends TestCase
{
    protected $context;

    protected function setUp(): void
    {
        $container = $this->getMockBuilder(PunchoutContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects($this->any())
            ->method('isPunchout')
            ->willReturn(false);
        $container->expects($this->any())
            ->method('getUserType')
            ->willReturn(2);

        $this->context = new PurchaseOrderContext($container);
    }


    public function testGetUserId()
    {
        $this->assertEquals(false, $this->context->getUserId());
    }

    public function testGetUserType()
    {
        $this->assertEquals(2, $this->context->getUserType());
    }
}
