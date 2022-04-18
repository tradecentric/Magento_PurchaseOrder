<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Exception\ValidatorException;
use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;

/**
 * Class PunchoutOrderRequestDto
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutOrderRequestDto implements PunchoutOrderRequestDtoInterface
{
    /**
     * @var string[]
     */
    protected $availableModes = ['test', 'development', 'production'];

    /**
     * @var string
     */
    protected $punchoutSession = '';

    /**
     * @var string
     */
    protected $mode = '';

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var array
     */
    protected $details = [];

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $sharedSecret = '';

    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var string
     */
    protected $storeCode = '';

    /**
     * PunchoutOrderRequestDto constructor.
     * @param string $punchout_session
     * @param string $shared_secret
     * @param string $store_code
     * @param string $mode
     * @param array $header
     * @param array $details
     * @param array $items
     * @param string $api_key
     * @throws ValidatorException
     */
    public function __construct(
        string $punchout_session,
        string $shared_secret,
        string $store_code,
        string $mode = '',
        array $header = [],
        array $details = [],
        array $items = [],
        string $api_key = ''
    ) {
        $this->punchoutSession = $punchout_session;
        $this->setMode($mode);
        $this->setHeader($header);
        $this->sharedSecret = $shared_secret;
        $this->setApiKey($api_key);
        $this->storeCode = $store_code;
        $this->setDetails($details);
        $this->setItems($items);
    }

    /**
     * @return string
     */
    public function getPunchoutSession(): string
    {
        return $this->punchoutSession;
    }

    /**
     * @param string $punchoutSession
     * @return $this
     */
    public function setPunchoutSession(string $punchoutSession): PunchoutOrderRequestDtoInterface
    {
        $this->punchoutSession = $punchoutSession;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function setMode(string $mode): PunchoutOrderRequestDtoInterface
    {
        $this->assertNotEmpty($mode);
        $this->assertModeValid($mode);
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     * @return PunchoutOrderRequestDtoInterface
     * @throws ValidatorException
     */
    public function setHeader(array $header): PunchoutOrderRequestDtoInterface
    {
        $this->assertNotEmpty($header);
        $this->header = $header;
        return $this;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param array $details
     * @return PunchoutOrderRequestDtoInterface
     * @throws ValidatorException
     */
    public function setDetails(array $details): PunchoutOrderRequestDtoInterface
    {
        $this->assertNotEmpty($details);
        $this->details = $details;
        return $this;
    }

    /**
     * @return string
     */
    public function getSharedSecret(): string
    {
        return $this->sharedSecret;
    }

    /**
     * @param string $sharedSecret
     * @return $this
     */
    public function setSharedSecret(string $sharedSecret): PunchoutOrderRequestDtoInterface
    {
        $this->sharedSecret = $sharedSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return PunchoutOrderRequestDtoInterface
     * @throws ValidatorException
     */
    public function setApiKey(string $apiKey): PunchoutOrderRequestDtoInterface
    {
        $this->assertNotEmpty($apiKey);
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreCode(): string
    {
        return $this->storeCode;
    }

    /**
     * @param string $storeCode
     * @return $this
     */
    public function setStoreCode(string $storeCode): PunchoutOrderRequestDtoInterface
    {
        $this->storeCode = $storeCode;
        return $this;
    }

    /**
     * @param array $items
     * @return PunchoutOrderRequestDtoInterface
     * @throws ValidatorException
     */
    public function setItems(array $items): PunchoutOrderRequestDtoInterface
    {
        $this->assertNotEmpty($items);
        $this->items = $items;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param $value
     * @throws ValidatorException
     */
    protected function assertNotEmpty($value)
    {
        if (empty($value) || (bool) $value) {
            throw new ValidatorException(__("Field %1 is empty", $value));
        }
    }

    /**
     * @param string $mode
     * @throws ValidatorException
     */
    protected function assertModeValid(string $mode)
    {
        if (!in_array($mode, $this->availableModes)) {
            throw new ValidatorException(__("Mode %1 is not valid", $mode));
        }
    }
}
