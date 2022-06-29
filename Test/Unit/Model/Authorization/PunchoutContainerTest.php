<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Model\Authorization;

use PHPUnit\Framework\TestCase;
use Punchout2Go\PurchaseOrder\Model\Authorization\PunchoutContainer;

class PunchoutContainerTest extends TestCase
{
    protected $container;

    protected function setUp(): void
    {
        $this->container = new PunchoutContainer();
    }

    public function testIsPunchoutTrue()
    {
        $this->assertTrue($this->container->isPunchout(true));
    }

    public function testIsPunchoutFalse()
    {
        $this->assertFalse($this->container->isPunchout());
    }

    public function testSetUserType()
    {
        $this->container->setUserType(123);
        $this->assertEquals(123, $this->container->getUserType());
    }
}
