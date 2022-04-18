<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PunchoutOrderRequestDtoInterface
{
    /**
     * @return string
     */
    public function getPunchoutSession(): string;

    /**
     * @param string $punchoutSession
     * @return $this
     */
    public function setPunchoutSession(string $punchoutSession): PunchoutOrderRequestDtoInterface;

    /**
     * @return string
     */
    public function getMode(): string;

    /**
     * @param string $mode
     * @return $this
     */
    public function setMode(string $mode): PunchoutOrderRequestDtoInterface;

    /**
     * @return array
     */
    public function getHeader(): array;

    /**
     * @param array $header
     * @return $this
     */
    public function setHeader(array $header): PunchoutOrderRequestDtoInterface;

    /**
     * @return array
     */
    public function getDetails(): array;

    /**
     * @param array $details
     * @return PunchoutOrderRequestDtoInterface
     */
    public function setDetails(array $details): PunchoutOrderRequestDtoInterface;

    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param array $items
     * @return PunchoutOrderRequestDtoInterface
     */
    public function setItems(array $items): PunchoutOrderRequestDtoInterface;

    /**
     * @return string
     */
    public function getSharedSecret(): string;

    /**
     * @param string $sharedSecret
     * @return $this
     */
    public function setSharedSecret(string $sharedSecret): PunchoutOrderRequestDtoInterface;

    /**
     * @return string
     */
    public function getApiKey(): string;

    /**
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey): PunchoutOrderRequestDtoInterface;

    /**
     * @return string
     */
    public function getStoreCode(): string;

    /**
     * @param string $storeCode
     * @return $this
     */
    public function setStoreCode(string $storeCode): PunchoutOrderRequestDtoInterface;
}
