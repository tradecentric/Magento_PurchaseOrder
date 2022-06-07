<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Punchout2Go\PurchaseOrder\Api\PuchoutApiKeyValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\HeaderInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderManagerInterface;
use Punchout2Go\PurchaseOrder\Api\StoreLoggerInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutOrderManager implements PunchoutOrderManagerInterface
{

    /**
     * @var PunchoutOrderRequestDtoInterfaceFactory
     */
    protected $factory;

    /**
     * @var SalesServiceInterface
     */
    protected $orderService;

    /**
     * @var PuchoutApiKeyValidatorInterface
     */
    protected $apiKeyValidator;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PunchoutQuoteExtender
     */
    protected $punchoutQuoteExtender;

    /**
     * @var StoreLoggerInterface
     */
    protected $logger;

    /**
     * PunchoutOrderManager constructor.
     * @param PunchoutOrderRequestDtoInterfaceFactory $factory
     * @param PunchoutQuoteExtender $punchoutQuoteExtender
     * @param SalesServiceInterface $orderService
     * @param StoreManagerInterface $storeManager
     * @param PuchoutApiKeyValidatorInterface $requestValidator
     * @param StoreLoggerInterface $logger
     */
    public function __construct(
        PunchoutOrderRequestDtoInterfaceFactory $factory,
        PunchoutQuoteExtender $punchoutQuoteExtender,
        SalesServiceInterface $orderService,
        StoreManagerInterface $storeManager,
        PuchoutApiKeyValidatorInterface $requestValidator,
        StoreLoggerInterface $logger
    ) {
        $this->orderService = $orderService;
        $this->apiKeyValidator = $requestValidator;
        $this->factory = $factory;
        $this->storeManager = $storeManager;
        $this->punchoutQuoteExtender = $punchoutQuoteExtender;
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
        $this->storeManager->setCurrentStore($store);
        if (!$this->apiKeyValidator->isValid($apiKey, $store->getId())) {
            throw new LocalizedException(__("API key is not valid"));
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
        return null;
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
