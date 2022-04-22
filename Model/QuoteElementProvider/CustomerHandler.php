<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;

/**
 * Class QuoteHandler
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class CustomerHandler implements QuoteElementHandlerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param QuoteBuildContainerInterface $quoteBuilder
     * @param QuoteInterface $punchoutQuote
     * @throws LocalizedException
     */
    public function handle(QuoteBuildContainerInterface $quoteBuilder, QuoteInterface $punchoutQuote): void
    {
        try {
            $customer = $this->customerRepository->get($punchoutQuote->getCustomer()->getEmail());
            $quoteBuilder->setCustomer($customer);
        } catch (NoSuchEntityException $e) {}
    }
}
