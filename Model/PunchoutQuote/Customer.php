<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\CustomerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface;

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
     * @var ExtraAttributeInterface[]
     */
    protected $extraData = [];

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
     * @param array $extra_data
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
        string $phone,
        array $extra_data = []
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
        $this->extraData = $extra_data;
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
    public function setName(string $name): CustomerInterface
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
    public function setAddressName(string $addressName): CustomerInterface
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
    public function setDeliverTo(string $deliverTo): CustomerInterface
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
    public function setStreet(string $street): CustomerInterface
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
    public function setCity(string $city): CustomerInterface
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
    public function setState(string $state): CustomerInterface
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
    public function setPostalCode(string $postalCode): CustomerInterface
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
    public function setCountry(string $country): CustomerInterface
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
    public function setCountryCode(string $countryCode): CustomerInterface
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
    public function setEmail(string $email): CustomerInterface
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
    public function setPhone(string $phone): CustomerInterface
    {
        $this->phone = $phone;
    }

    /**
     * @return ExtraAttributeInterface[]
     */
    public function getExtraData(): array
    {
        return $this->extraData;
    }

    /**
     * @param ExtraAttributeInterface[] $extra_data
     * @return HeaderInterface
     */
    public function setExtraData(array $extra_data): CustomerInterface
    {
        $this->extraData = $extra_data;
        return $this;
    }
}
