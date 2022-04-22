<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;

/**
 * Interface QuoteElementProviderInterface
 * @package Punchout2Go\PurchaseOrder\Api
 */
interface QuoteElementHandlerInterface
{
    /**
     * @param QuoteBuildContainerInterface $quoteBuilder
     * @param QuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $quoteBuilder, QuoteInterface $punchoutQuote): void;
}
