<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorContainerInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * Class ModeValidator
 * @package Punchout2Go\PurchaseOrder\Model\Validator
 */
class ModeValidator  implements PunchoutValidatorInterface
{
    /**
     * @var array
     */
    protected $availableModes;

    /**
     * @var ValidationResultFactory
     */
    protected $resultFactory;

    /**
     * ModeValidator constructor.
     * @param ValidationResultFactory $resultFactory
     * @param array $availableModes
     */
    public function __construct(
        ValidationResultFactory $resultFactory,
        array $availableModes
    ) {
        $this->availableModes = $availableModes;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param PunchoutValidatorContainerInterface $container
     * @return ValidationResult
     * @throws \Zend_Validate_Exception
     */
    public function validate(PunchoutValidatorContainerInterface $container): ValidationResult
    {
        $validator = new \Zend_Validate_InArray(['haystack' => $this->availableModes, 'strict' => true]);
        $validator->setMessage("Mode '%value%' is not valid", \Zend_Validate_InArray::NOT_IN_ARRAY);
        $validator->isValid($container->getMode());
        return $this->resultFactory->create(
            ['errors' => array_map(function($message) {
                return __($message);
            }, $validator->getMessages())]
        );
    }
}
