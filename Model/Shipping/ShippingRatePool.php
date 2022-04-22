<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Shipping;

use Magento\Framework\ObjectManager\TMapFactory;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\Rate;
use Punchout2Go\PurchaseOrder\Api\ShippingRateSelectorInterface;
use Magento\Framework\ObjectManager\Helper\Composite as CompositeHelper;

/**
 * Class ShippingRatePool
 * @package Punchout2Go\PurchaseOrder\Model\Shipping
 */
class ShippingRatePool implements ShippingRateSelectorInterface
{
    /**
     * @var \Magento\Framework\ObjectManager\TMap
     */
    protected $shippingHandlers;

    /**
     * @param TMapFactory $mapFactory
     * @param CompositeHelper $compositeHelper
     * @param array $shippingHandlers
     */
    public function __construct(
        TMapFactory $mapFactory,
        CompositeHelper $compositeHelper,
        array $shippingHandlers = []
    ) {
        $this->shippingHandlers = $mapFactory->create([
            'array' => array_column($compositeHelper->filterAndSortDeclaredComponents($shippingHandlers), 'type'),
            'type' => ShippingRateSelectorInterface::class
        ]);
    }

    /**
     * @param AddressInterface $address
     * @param null $storeId
     * @return Rate|null
     */
    public function getRateForAddress(AddressInterface $address, $storeId = null): ?Rate
    {
        $result = null;
        foreach ($this->shippingHandlers as $shippingHandler) {
            $rate = $shippingHandler->getRateForAddress($address, $storeId);
            if ($rate) {
                $result = $rate;
                break;
            }
        }
        return $result;
    }
}
