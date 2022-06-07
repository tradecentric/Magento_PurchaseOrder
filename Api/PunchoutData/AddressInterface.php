<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * Interface AddressInterface
 * @package Punchout2Go\PurchaseOrder\Api\PunchoutOrderRequestDto
 */
interface AddressInterface
{
    /**
     * @return string
     */
    public function getAddressId(): string;

    /**
     * @param string $address_id
     * @return AddressInterface
     */
    public function setAddressId(string $address_id): AddressInterface;

    /**
     * @return string
     */
    public function getAddressName(): string;

    /**
     * @param string $address_name
     * @return AddressInterface
     */
    public function setAddressName(string $address_name): AddressInterface;

    /**
     * @return string
     */
    public function getAddressCode(): string;

    /**
     * @param string $address_code
     * @return AddressInterface
     */
    public function setAddressCode(string $address_code): AddressInterface;

    /**
     * @return string
     */
    public function getDeliverto(): string;

    /**
     * @param string $deliverto
     * @return AddressInterface
     */
    public function setDeliverto(string $deliverto): AddressInterface;

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @param string $street
     * @return AddressInterface
     */
    public function setStreet(string $street): AddressInterface;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $city
     * @return AddressInterface
     */
    public function setCity(string $city): AddressInterface;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $state
     * @return AddressInterface
     */
    public function setState(string $state): AddressInterface;

    /**
     * @return string
     */
    public function getPostalcode(): string;

    /**
     * @param string $postalcode
     * @return AddressInterface
     */
    public function setPostalcode(string $postalcode): AddressInterface;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $country
     * @return AddressInterface
     */
    public function setCountry(string $country): AddressInterface;

    /**
     * @return string
     */
    public function getCountryCode(): string;

    /**
     * @param string $country_code
     * @return AddressInterface
     */
    public function setCountryCode(string $country_code): AddressInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return AddressInterface
     */
    public function setEmail(string $email): AddressInterface;

    /**
     * @return string
     */
    public function getTelephone(): string;

    /**
     * @param string $telephone
     * @return AddressInterface
     */
    public function setTelephone(string $telephone): AddressInterface;
}
