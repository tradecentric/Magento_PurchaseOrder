<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;


/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
interface AddressInterface
{
    /**
     * @return string
     */
    public function getAddressId(): string;

    /**
     * @param string $addressId
     */
    public function setAddressId(string $addressId): void;

    /**
     * @return string
     */
    public function getAddressName(): string;

    /**
     * @param string $addressName
     */
    public function setAddressName(string $addressName): void;

    /**
     * @return string
     */
    public function getAddressCode(): string;

    /**
     * @param string $addressCode
     */
    public function setAddressCode(string $addressCode): void;

    /**
     * @return string
     */
    public function getDeliverTo(): string;

    /**
     * @param string $deliverTo
     */
    public function setDeliverTo(string $deliverTo): void;

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @param string $street
     */
    public function setStreet(string $street): void;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $city
     */
    public function setCity(string $city): void;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $state
     */
    public function setState(string $state): void;

    /**
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $country
     */
    public function setCountry(string $country): void;

    /**
     * @return string
     */
    public function getCountryCode(): string;

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void;

    /**
     * @return string
     */
    public function getTelephone(): string;

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @return string
     */
    public function getLastName(): string;
}
