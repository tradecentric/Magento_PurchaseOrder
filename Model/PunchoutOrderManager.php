<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Punchout2Go\PurchaseOrder\Api\SalesServiceInterface;
use Punchout2Go\PurchaseOrder\Api\PuchoutOrderRequestValidatorInterface;
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
     * @var OrderServiceInterface
     */
    protected $orderService;

    /**
     * @var PuchoutOrderRequestValidatorInterface
     */
    protected $requestValidator;

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
     * @param PuchoutOrderRequestValidatorInterface $requestValidator
     * @param LoggerInterface $logger
     */
    public function __construct(
        Json $jsonSerializer,
        PunchoutOrderRequestDtoInterfaceFactory $factory,
        PunchoutQuoteBuilder $punchoutQuoteBuilder,
        SalesServiceInterface $orderService,
        PuchoutOrderRequestValidatorInterface $requestValidator,
        LoggerInterface $logger
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->orderService = $orderService;
        $this->requestValidator = $requestValidator;
        $this->factory = $factory;
        $this->punchoutQuoteBuilder = $punchoutQuoteBuilder;
        $this->logger = $logger;
    }

    /**
     * @param string $params
     * @return bool
     */
    public function create(string $params): string
    {
        $params = $this->getParams($params);
        $this->logger->info("Order create request with params " . print_r($params));
        /** @var \Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface $dto */
        $dto = $this->factory->create($params);
        $errors = $this->requestValidator->validate($dto);
        if (count($errors)) {
            throw new LocalizedException(implode(",", $errors));
        }

        $order = $this->orderService->createOrder($this->punchoutQuoteBuilder->build($dto));
        return $order->getIncrementId();
    }

    /**
     * @param string $apiKey
     * @throws LocalizedException
     */
    protected function validateApiKey(string $apiKey)
    {

    }

    /**
     * @param string $params
     * @return array
     */
    protected function getParams(string $params): array
    {
        try {
            $params = (array) $this->jsonSerializer->unserialize($params);
        } catch (\Exception $e) {
            $params = [];
        }
        return $params;
    }
}
