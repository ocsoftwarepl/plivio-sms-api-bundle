<?php

namespace OCSoftwarePL\PlivioSmsApiBundle\Sms\DTO;


class PlivioSendResponse
{
    public $smsId;
    public $message;
    public $status;
    public $raw;

    public function __construct(array  $response)
    {
        if (false === isset($response['response'], $response['status'])) {
            throw new \Exception('Invalid api response');
        }

        $this->smsId = $response['response']['message_uuid'][0];
        $this->status = $response['status'];
        $this->message = $response['response']['message'];
        $this->raw = serialize($response);
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return $this->status == '202';
    }

    /**
     * @return bool
     */
    public function failed()
    {
        return !$this->isOk();
    }

}