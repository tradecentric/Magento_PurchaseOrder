<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PuchoutOrderRequestValidator implements PuchoutOrderRequestValidatorInterface
{
    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @param array $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }

    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    public function validate(PunchoutOrderRequestDtoInterface $request): array
    {
        $result = [];
        foreach ($this->validators as $validator) {
            $result += $this->validaterequestWithValidator($validator, $request);
        }
        return $result;
    }

    /**
     * @param PuchoutOrderRequestValidatorInterface $validator
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    protected function validaterequestWithValidator(
        PuchoutOrderRequestValidatorInterface $validator,
        PunchoutOrderRequestDtoInterface $request
    ) {
        return $validator->validate($request);
    }
}
