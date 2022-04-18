<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Api\Data
 */
interface CustomerInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

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
    public function getPhone(): string;

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void;
}
