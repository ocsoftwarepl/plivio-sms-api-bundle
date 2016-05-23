<?php

namespace OCSoftwarePL\PlivioSmsApiBundle\Sms\DTO;

class Sms
{
    public $phone;
    public $msg;
    public $callbackUrl;

    public function __construct($phone, $msg, $callbackUrl = null)
    {
        $this->phone = $phone;
        $this->msg = $msg;
        $this->callbackUrl = $callbackUrl;
    }
}