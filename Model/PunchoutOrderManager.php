<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;
use Punchout2Go\PurchaseOrder\Api\PuchoutApiKeyValidatorInterface;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterfaceFactory;
use Psr\Log\LoggerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderManagerInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutOrderManager implements PunchoutOrderManagerInterface
{
    /**
     * @var Json
     */
    protected $jsonSerializer;

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
     * @var PunchoutQuoteBuilder
     */
    protected $punchoutQuoteBuilder;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Json $jsonSerializer
     * @param PunchoutOrderRequestDtoInterfaceFactory $factory
     * @param PunchoutQuoteBuilder $punchoutQuoteBuilder
     * @param SalesServiceInterface $orderService
     * @param StoreManagerInterface $storeManager
     * @param PuchoutApiKeyValidatorInterface $requestValidator
     * @param LoggerInterface $logger
     */
    public function __construct(
        Json $jsonSerializer,
        PunchoutOrderRequestDtoInterfaceFactory $factory,
        PunchoutQuoteBuilder $punchoutQuoteBuilder,
        SalesServiceInterface $orderService,
        StoreManagerInterface $storeManager,
        PuchoutApiKeyValidatorInterface $requestValidator,
        LoggerInterface $logger
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->orderService = $orderService;
        $this->apiKeyValidator = $requestValidator;
        $this->factory = $factory;
        $this->storeManager = $storeManager;
        $this->punchoutQuoteBuilder = $punchoutQuoteBuilder;
        $this->logger = $logger;
    }

    /**
     * @param string $params
     * @return int
     * @throws LocalizedException
     */
    public function create(string $params): int
    {
        $params = $this->getParams($params);
        $this->logger->info("Order create request with params " . var_export($params, true));
        if (!$params) {
            throw new LocalizedException(__("This request requires order data"));
        }
        /** @var \Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface $dto */
        $dto = $this->factory->create($params);
        $store = $this->getStore($dto->getStoreCode());
        if (!$store) {
            throw new LocalizedException(__("Store code %1 is not valid", $dto->getStoreCode()));
        }
        $this->storeManager->setCurrentStore($store);
        if (!$this->apiKeyValidator->isValid($dto->getApiKey(), $store->getId())) {
            throw new LocalizedException(__("API key is not valid"));
        }

        return $this->orderService->createOrder($this->punchoutQuoteBuilder->build($dto));
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
        } catch (NoSuchEntityException $e) {}
        return $result;
    }

    /**
     * @param string $params
     * @return array
     */
    protected function getParams(string $params): array
    {
        $result = [];
        try {
            $result = $this->jsonSerializer->unserialize($params);
        } catch (\Exception $e) {}
        return $result;
    }
}
