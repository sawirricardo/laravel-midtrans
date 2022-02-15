<?php

namespace Sawirricardo\Midtrans;

class CustomerDetail
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $billingAddress;
    public $shippingAddress;

    public function __construct(
        $firstName = null,
        $lastName = null,
        $email = null,
        $phone = null,
        BillingAddress $billingAddress = null,
        ShippingAddress $shippingAddress = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
    }

    public static function make()
    {
        return new static();
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

    public function setBillingAddress(BillingAddress|array $address)
    {
        dump($address);
        if ($address instanceof BillingAddress) {
            $this->billingAddress = $address;
        } else {
            $this->billingAddress = new BillingAddress(...$address);
        }

        return $this;
    }

    public function setShippingAddress(ShippingAddress|array $address)
    {
        if ($address instanceof ShippingAddress) {
            $this->shippingAddress = $address;
        } else {
            $this->shippingAddress = new ShippingAddress(...$address);
        }

        return $this;
    }
}
