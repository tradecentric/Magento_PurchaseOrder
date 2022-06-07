<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Magento\Framework\ObjectManager\TMapFactory;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Punchout2Go\PurchaseOrder\Api\StoreAwareInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorContainerInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\RequestValidatorInterface;

/**
 * Class PunchoutValidator
 * @package Punchout2Go\PurchaseOrder\Model\Validator
 */
class PunchoutValidator implements RequestValidatorInterface
{
    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var array
     */
    protected $resultFactory = [];

    /**
     * @var null
     */
    protected $storeId = null;

    /**
     * PunchoutValidator constructor.
     * @param ValidationResultFactory $resultFactory
     * @param TMapFactory $mapFactory
     * @param array $validators
     */
    public function __construct(
        ValidationResultFactory $resultFactory,
        TMapFactory $mapFactory,
        array $validators
    ) {
        $this->resultFactory = $resultFactory;
        $this->validators = $mapFactory->create([
            'array' => $validators,
            'type' => PunchoutValidatorInterface::class
        ]);
    }

    /**
     * @param PunchoutValidatorContainerInterface $container
     * @return ValidationResult
     */
    public function validate(PunchoutValidatorContainerInterface $container): ValidationResult
    {
        $result = [];
        foreach ($this->validators as $validator) {
            if ($validator instanceof StoreAwareInterface) {
                $validator->setStoreId($this->storeId);
            }
            $result = array_merge($result, $validator->validate($container)->getErrors());
        }
        return $this->resultFactory->create(['errors' => $result]);
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
