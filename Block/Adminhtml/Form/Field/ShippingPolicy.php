<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Block\Adminhtml\Form\Field;

/**
 * Class ShippingPolicy
 * @package Magento\CatalogInventory\Block\Adminhtml\Form\Field
 */
class ShippingPolicy extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var \Magento\Framework\View\Element\BlockInterface
     */
    protected $_shippingRenderer;

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getShippingRenderer()
    {
        if (!$this->_shippingRenderer) {
            $this->_shippingRenderer = $this->getLayout()->createBlock(
                \Punchout2Go\PurchaseOrder\Block\Adminhtml\Form\Field\ShippingMethods::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->_shippingRenderer->setClass('shipping_method_select admin__control-select');
        }
        return $this->_shippingRenderer;
    }

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'shipping_policy',
            ['label' => __('Shipping Method'), 'renderer' => $this->_getShippingRenderer()]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Shipping');
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getShippingRenderer()->calcOptionHash($row->getData('shipping_policy'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
