<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Framework\Validator\AbstractValidator;
use Punchout2Go\PurchaseOrder\Api\StoreAwareInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorContainerInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorInterface;

/**
 * Class ApiKeyValidator
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ApiKeyValidator implements PunchoutValidatorInterface, StoreAwareInterface
{
    /**
     * @var PuchoutApiKeyValidator
     */
    protected $validator;

    /**
     * @var ValidationResultFactory
     */
    protected $resultFactory;

    /**
     * @var string
     */
    protected $storeId = null;

    /**
     * ApiKeyValidator constructor.
     * @param PuchoutApiKeyValidator $validator
     * @param ValidationResultFactory $resultFactory
     */
    public function __construct(
        AbstractValidator $validator,
        ValidationResultFactory $resultFactory
    ) {
        $this->validator = $validator;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param PunchoutValidatorContainerInterface $container
     * @return ValidationResult
     * @throws \Zend_Validate_Exception
     */
    public function validate(PunchoutValidatorContainerInterface $container): ValidationResult
    {
        $this->validator->isValid($container->getApiKey(), $this->storeId);
        return $this->resultFactory->create([
            'errors' => array_map(function ($message) {
                return __($message);
            }, $this->validator->getMessages())
        ]);
    }

    /**
     * @param $storeId
     * @return StoreAwareInterface
     */
    public function setStoreId($storeId): StoreAwareInterface
    {
        $this->storeId = $storeId;
        return $this;
    }
}
