<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PuchoutApiKeyValidatorInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator
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
     * @return bool
     */
    public function isValid($apiKey): bool
    {
        if ($this->helper->getApiKey() !== base64_decode($apiKey)) {
            return false;
        }
        return true;
    }
}
