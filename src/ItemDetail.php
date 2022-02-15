<?php

namespace Sawirricardo\Midtrans;

class ItemDetail
{
    public $id;
    public  $price;
    public  $quantity;
    public  $name;
    public  $brand;
    public  $category;
    public  $merchantName;

    public function __construct(
        $id = null,
        $price = null,
        $quantity = null,
        $name = null,
        $brand = null,
        $category = null,
        $merchantName = null,
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->name = $name;
        $this->brand = $brand;
        $this->category = $category;
        $this->merchant_name = $merchantName;
    }

    public static function make()
    {
        return new static;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;
        return $this;
    }
}
