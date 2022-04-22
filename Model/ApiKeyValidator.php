<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PuchoutApiKeyValidatorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ApiKeyValidator
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ApiKeyValidator implements PuchoutApiKeyValidatorInterface
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
     * @param string $apiKey
     * @param null $storeId
     * @return bool
     */
    public function isValid($apiKey, $storeId = null): bool
    {
        if ($this->helper->getApiKey($storeId) !== base64_decode($apiKey)) {
            return false;
        }
        return true;
    }
}
