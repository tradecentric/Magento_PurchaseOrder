<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator;

use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

class ItemsValidator implements PuchoutOrderRequestValidatorInterface
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
        if (!in_array($request->getMode(), $this->helper->getAvailableModes())) {
            $result[] = __('Mode is not valid');
        }
        return $result;
    }
}
