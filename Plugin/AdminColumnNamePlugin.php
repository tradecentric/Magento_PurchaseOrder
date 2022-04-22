<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Framework\View\LayoutInterface;
use Magento\Sales\Block\Adminhtml\Items\Column\Name;
use Magento\Sales\Block\Adminhtml\Items\Column\DefaultColumn;
use Magento\Sales\Model\Order\Item;

/**
 * Class AdminColumnNamePlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class AdminColumnNamePlugin
{
    /**
     * @param Name $subject
     * @param string $result
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterToHtml(
        Name $subject,
        string $result
    ) {
        return $result . $this->getExtraInfo($subject->getLayout(), $subject->getItem());
    }

    /**
     * @param LayoutInterface $layout
     * @param Item $item
     * @return string
     */
    protected function getExtraInfo(LayoutInterface $layout, Item $item)
    {
        $block = $layout->createBlock(DefaultColumn::class);
        $block->setTemplate('Punchout2Go_PurchaseOrder::items/column/name.phtml');
        $block->setItem($item);
        return $block->toHtml();
    }
}
