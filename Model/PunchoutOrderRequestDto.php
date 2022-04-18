<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutQuoteDtoInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDtoInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model
 */
class PunchoutOrderRequestDto implements PunchoutOrderRequestDtoInterface
{
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
     * @param string $punchout_session
     * @param string $mode
     * @param array $header
     * @param array $details
     * @param array $items
     * @param string $shared_secret
     * @param string $api_key
     * @param string $store_code
     */
    public function __construct(
        string $punchout_session,
        string $mode,
        array $header,
        array $details,
        array $items,
        string $shared_secret,
        string $api_key,
        string $store_code
    ) {
        $this->punchoutSession = $punchout_session;
        $this->mode = $mode;
        $this->header = $header;
        $this->sharedSecret = $shared_secret;
        $this->apiKey = $api_key;
        $this->storeCode = $store_code;
        $this->details = $details;
        $this->items = $items;
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
     * @return $this
     */
    public function setHeader(array $header): PunchoutOrderRequestDtoInterface
    {
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
     */
    public function setDetails(array $details): PunchoutOrderRequestDtoInterface
    {
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
     * @return $this
     */
    public function setApiKey(string $apiKey): PunchoutOrderRequestDtoInterface
    {
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
     * @return $this
     */
    public function setItems(array $items): PunchoutOrderRequestDtoInterface
    {
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
}
