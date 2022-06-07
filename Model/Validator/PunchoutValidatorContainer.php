<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Validator;

use Punchout2Go\PurchaseOrder\Api\HeaderInterface;
use Punchout2Go\PurchaseOrder\Api\Validator\PunchoutValidatorContainerInterface;

/**
 * Class PunchoutValidationContainer
 * @package Punchout2Go\PurchaseOrder\Model\Validator
 */
class PunchoutValidatorContainer implements PunchoutValidatorContainerInterface
{
    /**
     * @var HeaderInterface
     */
    protected $header;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $sharedSecret;

    /**
     * PunchoutValidationContainer constructor.
     * @param HeaderInterface $header
     * @param string $apiKey
     * @param string $mode
     * @param string $sharedSecret
     */
    public function __construct(
        HeaderInterface $header,
        string $apiKey,
        string $mode,
        string $sharedSecret
    ) {
        $this->header = $header;
        $this->apiKey = $apiKey;
        $this->mode = $mode;
        $this->sharedSecret = $sharedSecret;
    }

    /**
     * @return HeaderInterface
     */
    public function getHeader(): HeaderInterface
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getSharedSecret(): string
    {
        return $this->sharedSecret;
    }
}
