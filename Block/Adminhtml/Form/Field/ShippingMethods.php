<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Punchout2Go\PurchaseOrder\Model\Config\Source\Allmethods;

/**
 * Class ShippingMethods
 * @package Punchout2Go\PurchaseOrder\Block\Adminhtml\Form\Field
 */
class ShippingMethods extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @var Allmethods
     */
    protected $allMethods;

    /**
     * @param Context $context
     * @param Allmethods $allMethods
     * @param array $data
     */
    public function __construct(
        Context $context,
        Allmethods $allMethods,
        array $data = []
    ) {
        $this->allMethods = $allMethods;
        parent::__construct($context, $data);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->addElementOptions($this->allMethods->toOptionArray(true));
        }
        return parent::_toHtml();
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * @param array $options
     */
    protected function addElementOptions(array $options)
    {
        foreach ($options as $shippingMethod) {
            if (is_array($shippingMethod['value'])) {
                $this->addElementOptions($shippingMethod['value']);
            } else {
                $this->addOption($shippingMethod['value'], $shippingMethod['label']);
            }
        }
    }
}
