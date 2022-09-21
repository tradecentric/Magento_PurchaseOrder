<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Block\Adminhtml\Form\Field;

use Magento\Backend\Block\Template\Context;
use Punchout2Go\PurchaseOrder\Model\Config\Source\Allmethods;
use Punchout2Go\PurchaseOrder\Block\Adminhtml\Form\Field\ShippingMethods;
use PHPUnit\Framework\TestCase;

class ShippingMethodsTest extends TestCase
{
    /**
     * @var string[][][][]
     */
    protected $shippingMethods = [
        'method1' => [
            'value' => [
                [
                    'value' => 'method1value1',
                    'label' => 'method1label1'
                ],
                [
                    'value' => 'method1value2',
                    'label' => 'method1label2'
                ]
            ]
        ],
        'method2' => [
            'value' => [
                [
                    'value' => 'method2value1',
                    'label' => 'method2label1'
                ],
                [
                    'value' => 'method2value2',
                    'label' => 'method2label2'
                ]
            ]
        ]
    ];

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $block;


    protected function setUp(): void
    {
        $context = $this->createMock(Context::class);
        $shippingMethods = $this->createMock(Allmethods::class);
        /*$shippingMethods->expects($this->once())
            ->method('toOptionArray')
            ->willReturn($this->shippingMethods);*/
        $this->block = new ShippingMethods($context, $shippingMethods, []);

    }

    public function testSetInputName()
    {
        $this->block->setInputName('test1');
        $this->assertEquals('test1', $this->block->getName());
    }
}
