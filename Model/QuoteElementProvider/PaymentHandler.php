<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\QuoteElementProvider;

use Magento\Quote\Api\Data\PaymentInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteBuildContainerInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteElementHandlerInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class PaymentHandler
 * @package Punchout2Go\PurchaseOrder\Model\QuoteElementProvider
 */
class PaymentHandler implements QuoteElementHandlerInterface
{
    /**
     * @var PaymentInterfaceFactory
     */
    protected $factory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param PaymentInterfaceFactory $factory
     * @param Data $helper
     */
    public function __construct(
        PaymentInterfaceFactory $factory,
        Data $helper
    ) {
        $this->factory = $factory;
        $this->helper = $helper;
    }

    /**
     * @param QuoteBuildContainerInterface $builder
     * @param PunchoutQuoteInterface $punchoutQuote
     */
    public function handle(QuoteBuildContainerInterface $builder, PunchoutQuoteInterface $punchoutQuote): void
    {
        $punchoutPayment = $punchoutQuote->getPayment();
        /** @var \Magento\Quote\Api\Data\PaymentInterface $payment */
        $payment = $this->factory->create();
        $payment->setPoNumber($punchoutPayment->getPayloadId() ?: $punchoutPayment->getOrderRequestId())
            ->setMethod($this->helper->getDefaultPaymentMethod($punchoutQuote->getStoreId()))
            ->setAdditionalInformation([
                'po_payload_id' => $punchoutPayment->getPoPayloadId(),
                'request_id' => $punchoutPayment->getOrderRequestId()
            ]);
        $builder->setPayment($payment);
    }
}
