<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Converter;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\AddressInterfaceFactory;
use Magento\Directory\Model\RegionFactory;
use Punchout2Go\PurchaseOrder\Api\AddressConverterInterface;
use Punchout2Go\PurchaseOrder\Api\Data\AddressInterface as PunchoutAddressInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model\Converter
 */
class AddressConverter implements AddressConverterInterface
{
    /**
     * @var AddressInterfaceFactory
     */
    protected $addressFactory;

    /**
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * @param AddressInterfaceFactory $addressFactory
     * @param RegionFactory $regionFactory
     */
    public function __construct(
        AddressInterfaceFactory $addressFactory,
        RegionFactory $regionFactory
    ) {
        $this->addressFactory = $addressFactory;
        $this->regionFactory = $regionFactory;
    }

    /**
     * @param PunchoutAddressInterface $address
     * @return AddressInterface
     */
    public function toOrderAddress(PunchoutAddressInterface $address): AddressInterface
    {
        /** @var \Magento\Quote\Api\Data\AddressInterface $quoteAddress */
        $quoteAddress = $this->addressFactory->create();
        $quoteAddress->setFirstname($address->getFirstName())
            ->setLastname($address->getLastName())
            ->setCompany($address->getAddressName())
            ->setStreet([$address->getStreet()])
            ->setCity($address->getCity())
            ->setPostcode($address->getPostalCode())
            ->setEmail($address->getEmail())
            ->setTelephone($address->getTelephone())
            ->setCountryId($address->getCountryCode())
            ->setAddressType($address->getType())
            ->setRegion($address->getState())
            ->setRegionCode($address->getState())
            ->setRegionId($this->getRegionIdFromCode($address->getState(), $address->getCountryCode()));
        return $quoteAddress;
    }

    /**
     * @param string $regionCode
     * @param string $countryId
     * @return mixed
     */
    public function getRegionIdFromCode(string $regionCode, string $countryId)
    {
        $directory = $this->regionFactory->create();
        $directory->loadByCode($regionCode, $countryId);
        return $directory->getId();
    }
}
