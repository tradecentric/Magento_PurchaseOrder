<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Converter;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartInterfaceFactory;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;
use Punchout2Go\PurchaseOrder\Api\QuoteConverterInterface;

/**
 * Class QuoteConverter
 * @package Punchout2Go\PurchaseOrder\Model\Converter
 */
class QuoteConverter implements QuoteConverterInterface
{
    /**
     * @var CartInterfaceFactory
     */
    protected $cartItemFactory;

    /**
     * @param CartInterfaceFactory $cartItemFactory
     */
    public function __construct(
        CartInterfaceFactory $cartItemFactory
    ) {
        $this->cartItemFactory = $cartItemFactory;
    }

    /**
     * @param PunchoutQuoteInterface $item
     * @return CartInterface
     */
    public function toQuote(PunchoutQuoteInterface $item): CartInterface
    {
        /** @var \Magento\Quote\Api\Data\CartInterface $cart */
        return $this->cartItemFactory->create()
            ->setOrderRequestId($item->getOrderRequestId());
    }
}
