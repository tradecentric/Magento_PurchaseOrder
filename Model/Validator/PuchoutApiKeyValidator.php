<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ApiKeyValidator
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PuchoutApiKeyValidator extends \Magento\Framework\Validator\AbstractValidator
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param mixed $apiKey
     * @param null $storeId
     * @return bool
     */
    public function isValid($apiKey, $storeId = null)
    {
        if ($this->helper->getApiKey($storeId) === base64_decode($apiKey)) {
            return true;
        }
        parent::_addMessages(["API key is not valid"]);
        return false;
    }
}
