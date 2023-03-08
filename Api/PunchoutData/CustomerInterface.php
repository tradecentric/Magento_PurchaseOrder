<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

/**
 * Interface CustomerInterface
 * @package Punchout2Go\PurchaseOrder\Api\PunchoutData
 */
interface CustomerInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     * @return CustomerInterface
     */
    public function setName(string $name): CustomerInterface;

    /**
     * @return string|null
     */
    public function getAddressName(): ?string;

    /**
     * @param string $address_name
     * @return CustomerInterface
     */
    public function setAddressName(string $address_name): CustomerInterface;

    /**
     * @return string
     */
    public function getDeliverto(): ?string;

    /**
     * @param string $deliverto
     * @return CustomerInterface
     */
    public function setDeliverto(string $deliverto): CustomerInterface;

    /**
     * @return string
     */
    public function getStreet(): ?string;

    /**
     * @param string $street
     * @return CustomerInterface
     */
    public function setStreet(string $street): CustomerInterface;

    /**
     * @return string
     */
    public function getCity(): ?string;

    /**
     * @param string $city
     * @return CustomerInterface
     */
    public function setCity(string $city): CustomerInterface;

    /**
     * @return string
     */
    public function getState(): ?string;

    /**
     * @param string $state
     * @return CustomerInterface
     */
    public function setState(string $state): CustomerInterface;

    /**
     * @return string
     */
    public function getPostalcode(): ?string;

    /**
     * @param string $postalcode
     * @return CustomerInterface
     */
    public function setPostalcode(string $postalcode): CustomerInterface;

    /**
     * @return string
     */
    public function getCountry(): ?string;

    /**
     * @param string $country
     * @return CustomerInterface
     */
    public function setCountry(string $country): CustomerInterface;

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string;

    /**
     * @param string $country_code
     * @return CustomerInterface
     */
    public function setCountryCode(string $country_code): CustomerInterface;

    /**
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * @param string $email
     * @return CustomerInterface
     */
    public function setEmail(string $email): CustomerInterface;

    /**
     * @return string
     */
    public function getPhone(): ?string;

    /**
     * @param string $phone
     * @return CustomerInterface
     */
    public function setPhone(string $phone): CustomerInterface;

    /**
     * @return \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[]
     */
    public function getExtraData(): array;

    /**
     * @param \Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface[] $extra_data
     * @return HeaderInterface
     */
    public function setExtraData(array $extra_data): CustomerInterface;
}
