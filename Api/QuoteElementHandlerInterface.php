<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;

/**
 * Interface QuoteElementProviderInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteElementHandlerInterface
{
    /**
     * @param QuoteBuildContainerInterface $quoteBuilder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $quoteBuilder, PunchoutQuoteInterface $punchoutQuote): void;
}
