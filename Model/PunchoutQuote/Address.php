<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\AddressInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface;

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
     * @var ExtraAttributeInterface[]
     */
    protected $extraData = [];

    /**
     * @param string $address_id
     * @param string $address_name
     * @param string $address_code
     * @param string $deliverto
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $postalcode
     * @param string $country
     * @param string $country_code
     * @param string $email
     * @param string $telephone
     * @param string $type
     * @param array $extra_data
     */
    public function __construct(
        string $address_id,
        string $address_name,
        string $address_code,
        string $deliverto,
        string $street,
        string $city,
        string $state,
        string $postalcode,
        string $country,
        string $country_code,
        string $email,
        string $telephone,
        string $type = '',
        array $extra_data = []
    ) {
        $this->addressId = $address_id;
        $this->addressName = $address_name;
        $this->addressCode = $address_code;
        $this->deliverTo = $deliverto;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalcode;
        $this->country = $country;
        $this->countryCode = $country_code;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->type = $type;
        $this->extraData = $extra_data;
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
     * @return AddressInterface
     */
    public function setAddressId(string $addressId): AddressInterface
    {
        $this->addressId = $addressId;
        return $this;
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
     * @return AddressInterface
     */
    public function setAddressName(string $addressName): AddressInterface
    {
        $this->addressName = $addressName;
        return $this;
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
     * @return AddressInterface
     */
    public function setAddressCode(string $addressCode): AddressInterface
    {
        $this->addressCode = $addressCode;
        return $this;
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
    public function setDeliverTo(string $deliverTo): AddressInterface
    {
        $this->deliverTo = $deliverTo;
        $this->firstName = $this->lastName = null;
        return $this;
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
     * @return AddressInterface
     */
    public function setStreet(string $street): AddressInterface
    {
        $this->street = $street;
        return $this;
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
     * @return AddressInterface
     */
    public function setCity(string $city): AddressInterface
    {
        $this->city = $city;
        return $this;
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
     * @return AddressInterface
     */
    public function setState(string $state): AddressInterface
    {
        $this->state = $state;
        return $this;
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
     * @return AddressInterface
     */
    public function setPostalCode(string $postalCode): AddressInterface
    {
        $this->postalCode = $postalCode;
        return $this;
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
     * @return AddressInterface
     */
    public function setCountry(string $country): AddressInterface
    {
        $this->country = $country;
        return $this;
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
     * @return AddressInterface
     */
    public function setCountryCode(string $countryCode): AddressInterface
    {
        $this->countryCode = $countryCode;
        return $this;
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
     * @return AddressInterface
     */
    public function setEmail(string $email): AddressInterface
    {
        $this->email = $email;
        return $this;
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
     * @return AddressInterface
     */
    public function setTelephone(string $telephone): AddressInterface
    {
        $this->telephone = $telephone;
        return $this;
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
     * @return AddressInterface
     */
    public function setType(string $type): AddressInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        if ($this->firstName !== null) {
            return $this->firstName;
        }
        list($firstName, $lastName) = $this->parseFullName($this->getDeliverTo());
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
        list($firstName, $lastName) = $this->parseFullName($this->getDeliverTo());
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        return $this->lastName;
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
    public function setExtraData(array $extra_data): AddressInterface
    {
        $this->extraData = $extra_data;
        return $this;
    }

    /**
     * @param $fullName
     * @return array
     */
    protected function parseFullName($fullName)
    {
        if (preg_match('/^([^,]+),(.+)$/', $fullName,$s)) {
            return [trim($s[2]), trim($s[1])];
        }
        return array_pad(explode(' ', $fullName), 2, '');
    }
}
