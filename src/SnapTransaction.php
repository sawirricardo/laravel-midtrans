<?php

namespace Sawirricardo\Midtrans;

class SnapTransaction
{
    public $redirectUrl;
    public $token;

    public function __construct($redirectUrl, $token)
    {
        $this->redirectUrl = $redirectUrl;
        $this->token = $token;
    }
}
