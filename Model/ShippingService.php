<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model;

use Magento\Framework\Pricing\PriceCurrencyInterface as PriceRounder;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Punchout2Go\PurchaseOrder\Api\ShippingServiceInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * Class ShippingService
 * @package Punchout2Go\PurchaseOrder\Model
 */
class ShippingService implements ShippingServiceInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var
     */
    protected $priceRounder;

    /**
     * QuoteAddressPlugin constructor.
     * @param Data $helper
     * @param PriceRounder $priceRounder
     */
    public function __construct(
        Data $helper,
        PriceRounder $priceRounder
    ) {
        $this->helper = $helper;
        $this->priceRounder = $priceRounder;
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @param AbstractItem|null $abstractItem
     * @return bool
     */
    public function deleteShippingForNonPurchaseOrderEntities(Address $address, string $shippingCode, ?AbstractItem $abstractItem = null): bool
    {
        $clearedRates = $this->deleteShippingRateForNonPurchaseOrderAddress($address, $shippingCode);
        if (!$clearedRates) {
            return false;
        }
        if ($address->getShippingMethod() !== $shippingCode) {
            return false;
        }
        return $this->clearShippingDataForNonPurchaseOrderItem($abstractItem);
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @param float $price
     * @return bool
     * @throws \Exception
     */
    public function setCustomPriceForShippingMethod(Address $address, string $shippingCode, float $price): bool
    {
        $rateChanged = $this->setShippingPriceForShippingRate($address, $shippingCode, $price);
        if (!$rateChanged) {
            return false;
        }
        return $this->setShippingPriceForShippingAddress($address, $shippingCode, $price);
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @return bool
     */
    protected function deleteShippingRateForNonPurchaseOrderAddress(Address $address, string $shippingCode): bool
    {
        $rate = $this->getShippingRateByCode($address, $shippingCode);
        if (!$rate) {
            return false;
        }
        // dont show shipping rate for punchout on frontend
        $rate->isDeleted(true);
        return true;
    }

    /**
     * @param AbstractItem|null $item
     * @return bool
     */
    protected function clearShippingDataForNonPurchaseOrderItem(?AbstractItem $item = null): bool
    {
        if (!$item) {
            return false;
        }
        $item->unsShippingMethod()
            ->unsBaseShippingAmount()
            ->unsShippingAmount();

        return true;
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @param float $price
     * @return bool
     * @throws \Exception
     */
    protected function setShippingPriceForShippingAddress(Address $address, string $shippingCode, float $price)
    {
        if ($address->getShippingMethod() != $shippingCode) {
            return false;
        }
        $quote = $address->getQuote();
        $amountPrice = $quote->getStore()->getBaseCurrency()
            ->convert($price, $quote->getStore()->getCurrentCurrencyCode());
        $address->setBaseShippingAmount($this->priceRounder->round($price));
        $address->setShippingAmount($amountPrice);
        return true;
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @param float $price
     * @return bool
     */
    protected function setShippingPriceForShippingRate(Address $address, string $shippingCode, float $price) : bool
    {
        if (!$price) {
            return false;
        }
        /** @var Quote $quote */
        $quote = $address->getQuote();
        if (!$this->helper->isAllowedProvidedShipping($quote->getStoreId())) {
            return false;
        }
        $rate = $this->getShippingRateByCode($address, $shippingCode);
        if (!$rate) {
            return false;
        }
        $rate->setPrice($this->priceRounder->round($price));
        return true;
    }

    /**
     * @param Address $address
     * @param string $shippingCode
     * @return false|mixed
     */
    protected function getShippingRateByCode(Address $address, string $shippingCode)
    {
        return current(
            array_filter($address->getAllShippingRates(), function($rate) use ($shippingCode) {
                return $rate->getCode() == $shippingCode;
            })
        );
    }
}
