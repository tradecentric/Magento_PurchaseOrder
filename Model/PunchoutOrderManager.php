<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Magento\Store\Model\StoreManagerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\HeaderInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderManagerInterface;
use Punchout2Go\PurchaseOrder\Logger\StoreLoggerInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorContainerInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\Validator\RequestValidatorInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutOrderManager implements PunchoutOrderManagerInterface
{
    /**
     * @var SalesServiceInterface
     */
    protected $orderService;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PunchoutQuoteExtender
     */
    protected $punchoutQuoteExtender;

    /**
     * @var RequestValidatorInterface
     */
    protected $requestValidator;

    /**
     * @var PunchoutValidatorContainerInterfaceFactory
     */
    protected $validatorContainerFactory;

    /**
     * @var StoreLoggerInterface
     */
    protected $logger;

    /**
     * PunchoutOrderManager constructor.
     * @param PunchoutQuoteExtender $punchoutQuoteExtender
     * @param SalesServiceInterface $orderService
     * @param StoreManagerInterface $storeManager
     * @param RequestValidatorInterface $requestValidator
     * @param PunchoutValidatorContainerInterfaceFactory $validatorContainerFactory
     * @param StoreLoggerInterface $logger
     */
    public function __construct(
        PunchoutQuoteExtender $punchoutQuoteExtender,
        SalesServiceInterface $orderService,
        StoreManagerInterface $storeManager,
        RequestValidatorInterface $requestValidator,
        PunchoutValidatorContainerInterfaceFactory $validatorContainerFactory,
        StoreLoggerInterface $logger
    ) {
        $this->orderService = $orderService;
        $this->requestValidator = $requestValidator;
        $this->storeManager = $storeManager;
        $this->punchoutQuoteExtender = $punchoutQuoteExtender;
        $this->validatorContainerFactory = $validatorContainerFactory;
        $this->logger = $logger;
    }

    /**
     * @param HeaderInterface $header
     * @param PunchoutQuoteInterface $details
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface[] $items
     * @param string $punchoutSession
     * @param string $mode
     * @param string $sharedSecret
     * @param string $apiKey
     * @param string $storeCode
     * @return int|null
     * @throws LocalizedException
     */
    public function create(
        HeaderInterface $header,
        PunchoutQuoteInterface $details,
        array $items,
        string $punchoutSession,
        string $mode,
        string $sharedSecret,
        string $apiKey,
        string $storeCode
    ): ?int {
        $store = $this->getStore($storeCode);
        if (!$store) {
            throw new LocalizedException(__("Store code %1 is not valid", $storeCode));
        }
        $this->logger->setStoreId((string) $store->getId());
        $this->logger->info("Order create request with params " . var_export($details, true));
        $this->logger->info("Order create request for items " . var_export($items, true));
        $this->storeManager->setCurrentStore($store);
        $validationResult = $this->requestValidator
            ->setStoreId($store->getId())
            ->validate($this->validatorContainerFactory->create([
                'header' => $header,
                'apiKey' => $apiKey,
                'mode' => $mode,
                'sharedSecret' => $sharedSecret
            ])
        );
        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Create order request validation failed'), null, 0 , $validationResult);
        }
        try {
            return $this->orderService->createOrder(
                $this->punchoutQuoteExtender->extend($details, $header, $store, $items)
            );
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        throw new \Exception('Something went wrong. The order has not been created. Check Magento logs for more information');
    }

    /**
     * @param string $storeCode
     * @return \Magento\Store\Api\Data\StoreInterface|null
     */
    protected function getStore(string $storeCode)
    {
        $result = null;
        try {
            $result = $this->storeManager->getStore($storeCode);
        } catch (NoSuchEntityException $e) {
            $this->logger->error("Store with code " . $storeCode . " was not found");
        }
        return $result;
    }
}
