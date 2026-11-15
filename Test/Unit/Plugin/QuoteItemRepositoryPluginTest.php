<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Test\Unit\Plugin;

use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\Item\Repository;
use PHPUnit\Framework\TestCase;
use Punchout2Go\Punchout\Api\SessionInterface;
use Punchout2Go\PurchaseOrder\Api\Data\PurchaseOrderQuoteItemInterfaceFactory;
use Punchout2Go\PurchaseOrder\Model\PurchaseOrderQuoteItem;
use Punchout2Go\PurchaseOrder\Model\ResourceModel\PurchaseOrderQuoteItem as PurchaseOrderQuoteItemResource;
use Punchout2Go\PurchaseOrder\Plugin\QuoteItemRepositoryPlugin;

class QuoteItemRepositoryPluginTest extends TestCase
{
    public function testAfterSaveStoresPurchaseOrderDataUnderQuoteItemId()
    {
        $model = $this->createModel();
        $factory = $this->createMock(PurchaseOrderQuoteItemInterfaceFactory::class);
        $factory->method('create')->willReturn($model);
        $saved = null;
        $resource = $this->createMock(PurchaseOrderQuoteItemResource::class);
        $resource->expects($this->once())->method('save')->willReturnCallback(
            function ($item) use (&$saved, $resource) {
                $saved = $item;
                return $resource;
            }
        );
        $plugin = new QuoteItemRepositoryPlugin($resource, $factory, $this->createMock(SessionInterface::class));

        $plugin->afterSave($this->createMock(Repository::class), $this->createQuoteItem());

        $this->assertSame($model, $saved);
        $this->assertSame('42', $saved->getId());
        $this->assertSame('42', $saved->getItemId());
        $this->assertSame('PO-1', $saved->getPoNumber());
        $this->assertSame('L-1', $saved->getLineNumber());
        $this->assertSame('R-1', $saved->getOrderRequestId());
    }

    private function createQuoteItem(): Item
    {
        $extensionAttributes = new class {
            public function getOrderRequestId(): string
            {
                return 'R-1';
            }

            public function getLineNumber(): string
            {
                return 'L-1';
            }

            public function getPoNumber(): string
            {
                return 'PO-1';
            }
        };
        $quoteItem = $this->createMock(Item::class);
        $quoteItem->method('isDeleted')->willReturn(false);
        $quoteItem->method('getId')->willReturn(42);
        $quoteItem->method('getExtensionAttributes')->willReturn($extensionAttributes);

        return $quoteItem;
    }

    private function createModel(): PurchaseOrderQuoteItem
    {
        $model = (new \ReflectionClass(PurchaseOrderQuoteItem::class))->newInstanceWithoutConstructor();
        $idField = new \ReflectionProperty(\Magento\Framework\Model\AbstractModel::class, '_idFieldName');
        $idField->setValue($model, 'item_id');

        return $model;
    }
}
