<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\Data\AddressInterface;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class Address implements AddressInterface
{
    /**
     * @var string
     */
    protected $addressId = "";

    /**
     * @var string
     */
    protected $addressName = "";

    /**
     * @var string
     */
    protected $addressCode = "";

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
    protected $telephone = "";

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var null
     */
    protected $firstName = null;

    /**
     * @var null
     */
    protected $lastName = null;

    /**
     * @param string $address_id
     * @param string $address_name
     * @param string $address_code
     * @param string $deliver_to
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $postalcode
     * @param string $country
     * @param string $country_code
     * @param string $email
     * @param string $telephone
     * @param string $type
     */
    public function __construct(
        string $address_id,
        string $address_name,
        string $address_code,
        string $deliver_to,
        string $street,
        string $city,
        string $state,
        string $postalcode,
        string $country,
        string $country_code,
        string $email,
        string $telephone,
        string $type
    ) {
        $this->addressId = $address_id;
        $this->addressName = $address_name;
        $this->addressCode = $address_code;
        $this->deliverTo = $deliver_to;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalcode;
        $this->country = $country;
        $this->countryCode = $country_code;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAddressId(): string
    {
        return $this->addressId;
    }

    /**
     * @param string $addressId
     */
    public function setAddressId(string $addressId): void
    {
        $this->addressId = $addressId;
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
    public function getAddressCode(): string
    {
        return $this->addressCode;
    }

    /**
     * @param string $addressCode
     */
    public function setAddressCode(string $addressCode): void
    {
        $this->addressCode = $addressCode;
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
        $this->firstName = $this->lastName = null;
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
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        if ($this->firstName !== null) {
            return $this->firstName;
        }
        $parsedFullName = $this->parseFullName($this->getDeliverTo());
        $this->firstName =  array_shift($parsedFullName);
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        if ($this->lastName !== null) {
            return $this->lastName;
        }
        $parsedFullName = $this->parseFullName($this->getDeliverTo());
        array_shift($parsedFullName);
        $this->lastName = implode(" ", $parsedFullName);
        return $this->lastName;
    }

    /**
     * @param $fullName
     * @return array|false|string[]
     */
    protected function parseFullName($fullName)
    {
        if (preg_match('/^([^,]+),(.+)$/', $fullName,$s)) {
            return [trim($s[2]), trim($s[1])];
        }
        return explode(' ', $fullName);
    }
}
