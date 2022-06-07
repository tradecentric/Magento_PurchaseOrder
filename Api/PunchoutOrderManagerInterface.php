<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Magento\Framework\Exception\LocalizedException;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface PunchoutOrderManagerInterface
{
    /**
     * @param HeaderInterface $header
     * @param PunchoutQuoteInterface $details
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface[] $items
     * @param string $punschoutSession
     * @param string $mode
     * @param string $sparedSecret
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
    ): ?int;
}
