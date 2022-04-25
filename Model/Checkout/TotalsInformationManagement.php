<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Checkout;

use Magento\Checkout\Api\Data\TotalsInformationInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\CartInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\TotalsInformationManagementInterface;
use Punchout2Go\PurchaseOrder\Api\ShippingRateSelectorInterface;

/**
 * Class TotalsInformationManagement
 * @package Punchout2Go\PurchaseOrder\Model\Checkout
 */
class TotalsInformationManagement implements TotalsInformationManagementInterface
{
    /**
     * @var ShippingRateSelectorInterface
     */
    protected $alternativeShippingRateSelector;

    /**
     * @param ShippingRateSelectorInterface $shippingRateSelector
     */
    public function __construct(ShippingRateSelectorInterface $shippingRateSelector)
    {
        $this->alternativeShippingRateSelector = $shippingRateSelector;
    }

    /**
     * @param CartInterface $quote
     * @param TotalsInformationInterface $addressInformation
     * @return mixed|void
     */
    public function calculate(CartInterface $quote, TotalsInformationInterface $addressInformation)
    {
        $this->validateQuote($quote);

        if ($quote->getIsVirtual()) {
            $quote->setBillingAddress($addressInformation->getAddress());
        } else {
            $quote->setShippingAddress($addressInformation->getAddress());
            $quote->getShippingAddress()->getShippingRatesCollection()->clear();
            if ($addressInformation->getShippingCarrierCode() && $addressInformation->getShippingMethodCode()) {
                $quote->getShippingAddress()->setCollectShippingRates(true)->setShippingMethod(
                    $addressInformation->getShippingCarrierCode().'_'.$addressInformation->getShippingMethodCode()
                );
            } else {
                $quote->getShippingAddress()->setCollectShippingRates(true)->collectShippingRates();
                $rate = $this->alternativeShippingRateSelector->getRateForAddress($quote->getShippingAddress(), $quote->getStoreId());
                if (!$rate) {
                    throw new LocalizedException(__("No shipping method was found, throwing out"));
                }
                $quote->getShippingAddress()->setCollectShippingRates(true)->setShippingMethod($rate->getCode());
            }
        }
        $quote->setTotalsCollectedFlag(false)->collectTotals();
    }

    /**
     * Check if quote have items.
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    protected function validateQuote(\Magento\Quote\Model\Quote $quote)
    {
        if ($quote->getItemsCount() === 0) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Totals calculation is not applicable to empty cart')
            );
        }
    }
}
