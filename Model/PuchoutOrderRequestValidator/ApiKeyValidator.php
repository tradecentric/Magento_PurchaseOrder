<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator;

use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator
 */
class ApiKeyValidator implements PuchoutOrderRequestValidatorInterface
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
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    public function validate(PunchoutOrderRequestDtoInterface $request): array
    {
        $result = [];
        if (!$request->getApiKey()) {
            $result[] = __('Error : no API key provided');
        }
        if ($this->helper->getApiKey() !== base64_decode($request->getApiKey())) {
            $result[] = __('Error : API key is not valid');
        }
        return $result;
    }
}
