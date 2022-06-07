<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Framework\ObjectManager\TMapFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Magento\Framework\ObjectManager\Helper\Composite as CompositeHelper;

/**
 * Class QuoteElementProviderList
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class QuoteElementHandlerList implements QuoteElementHandlerInterface
{
    /**
     * @var \Magento\Framework\ObjectManager\TMap
     */
    protected $elementHandlers;

    /**
     * @param CompositeHelper $compositeHelper
     * @param TMapFactory $mapFactory
     * @param array $elementHandlers
     */
    public function __construct(
        CompositeHelper $compositeHelper,
        TMapFactory $mapFactory,
        array $elementHandlers = []
    ) {
        $this->elementHandlers = $mapFactory->create([
            'array' => array_column($compositeHelper->filterAndSortDeclaredComponents($elementHandlers), 'type'),
            'type' => QuoteElementHandlerInterface::class
        ]);
    }

    /**
     * @param QuoteBuildContainerInterface $quoteBuilder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $quoteBuilder, PunchoutQuoteInterface $punchoutQuote): void
    {
        foreach ($this->elementHandlers as $handler) {
            $handler->handle($quoteBuilder, $punchoutQuote);
        }
    }
}
