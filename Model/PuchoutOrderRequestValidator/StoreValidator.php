<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreIsInactiveException;
use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PuchoutOrderRequestValidator
 */
class StoreValidator implements PuchoutOrderRequestValidatorInterface
{
    /**
     * @var StoreRepositoryInterface
     */
    protected $repository;

    /**
     * @param StoreRepositoryInterface $repository
     */
    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PunchoutOrderRequestDtoInterface $request
     * @return array
     */
    public function validate(PunchoutOrderRequestDtoInterface $request): array
    {
        $storeCode = $request->getStoreCode();
        if (!$storeCode) {
            return [__("Store Code is empty")];
        }
        try {
            $this->repository->getActiveStoreByCode($storeCode);
        } catch (NoSuchEntityException $e) {
            return [__("Store Code is not valid")];
        } catch (StoreIsInactiveException $e) {
            return [__("Selected Store is not enabled")];
        }
        return [];
    }
}
