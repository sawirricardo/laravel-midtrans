<?php

namespace Sawirricardo\Midtrans;

class BillingAddress
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $postalCode;
    public $countryCode;

    public function __construct(
        $firstName = null,
        $lastName = null,
        $email = null,
        $phone = null,
        $address = null,
        $city = null,
        $postalCode = null,
        $countryCode = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
    }

    public static function make()
    {
        return new static;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setFirstName($name)
    {
        $this->firstName = $name;
        return $this;
    }

    public function setLastName($name)
    {
        $this->lastName = $name;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function postalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setCountryCode($countryCode = 'IDN')
    {
        $this->countryCode = $countryCode;
        return $this;
    }
}
