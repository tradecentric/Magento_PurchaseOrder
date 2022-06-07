<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Punchout2Go\PurchaseOrder\Api\PuchoutApiKeyValidatorInterface;
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
     * @var PuchoutApiKeyValidatorInterface
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
     * @param PuchoutApiKeyValidatorInterface $validator
     * @param ValidationResultFactory $resultFactory
     */
    public function __construct(
        PuchoutApiKeyValidatorInterface $validator,
        ValidationResultFactory $resultFactory
    ) {
        $this->validator = $validator;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param PunchoutValidatorContainerInterface $container
     * @return ValidationResult
     */
    public function validate(PunchoutValidatorContainerInterface $container): ValidationResult
    {
        $errors = [];
        if (!$this->validator->isValid($container->getApiKey(), $this->storeId)) {
            array_push($errors, __("API key is not valid"));
        }
        return $this->resultFactory->create(['errors' => $errors]);
    }

    /**
     * @param $storeId
     * @return PunchoutValidatorInterface
     */
    public function setStoreId($storeId): StoreAwareInterface
    {
        $this->storeId = $storeId;
        return $this;
    }
}
