<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class Customer implements CustomerInterface
{
    /**
     * @var string
     */
    protected $name = "";

    /**
     * @var string
     */
    protected $addressName = "";

    /**
     * @var string
     */
    protected $deliverTo = "";

    /**
     * @var string
     */
    protected $street = "";

    /**
     * @var string
     */
    protected $city = "";

    /**
     * @var string
     */
    protected $state = "";

    /**
     * @var string
     */
    protected $postalCode = "";

    /**
     * @var string
     */
    protected $country = "";

    /**
     * @var string
     */
    protected $countryCode = "";

    /**
     * @var string
     */
    protected $email = "";

    /**
     * @var string
     */
    protected $phone = "";

    /**
     * @param string $name
     * @param string $address_name
     * @param string $deliverto
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $postalcode
     * @param string $country
     * @param string $country_code
     * @param string $email
     * @param string $phone
     */
    public function __construct(
        string $name,
        string $address_name,
        string $deliverto,
        string $street,
        string $city,
        string $state,
        string $postalcode,
        string $country,
        string $country_code,
        string $email,
        string $phone
    ) {
        $this->name = $name;
        $this->addressName = $address_name;
        $this->deliverTo = $deliverto;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalcode;
        $this->country = $country;
        $this->countryCode = $country_code;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddressName(): string
    {
        return $this->addressName;
    }

    /**
     * @param string $addressName
     */
    public function setAddressName(string $addressName): void
    {
        $this->addressName = $addressName;
    }

    /**
     * @return string
     */
    public function getDeliverTo(): string
    {
        return $this->deliverTo;
    }

    /**
     * @param string $deliverTo
     */
    public function setDeliverTo(string $deliverTo): void
    {
        $this->deliverTo = $deliverTo;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
