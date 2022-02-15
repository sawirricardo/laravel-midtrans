<?php

namespace Sawirricardo\Midtrans;

class TransactionDetail
{
    public $orderId;
    public int $grossAmount;

    public function __construct($orderId = null, $grossAmount = null)
    {
        $this->orderId = $orderId;
        $this->grossAmount = $grossAmount;
    }

    public static function make()
    {
        return new static;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function setGrossAmount($grossAmount)
    {
        $this->grossAmount = $grossAmount;
        return $this;
    }
}
