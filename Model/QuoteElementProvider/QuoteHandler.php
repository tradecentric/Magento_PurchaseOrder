<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteConverterInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;

/**
 * Class QuoteHandler
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class QuoteHandler implements QuoteElementHandlerInterface
{

    /**
     * @var QuoteConverterInterface
     */
    protected $quoteConverter;

    /**
     * @param QuoteConverterInterface $quoteConverter
     */
    public function __construct(
        QuoteConverterInterface $quoteConverter
    ) {
        $this->quoteConverter = $quoteConverter;
    }

    /**
     * @param QuoteBuildContainerInterface $builder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $builder, PunchoutQuoteInterface $punchoutQuote): void
    {
        $builder->setQuote($this->quoteConverter->toQuote($punchoutQuote));
    }
}
