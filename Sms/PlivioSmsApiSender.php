<?php

namespace OCSoftwarePL\PlivioSmsApiBundle\Sms;


use OCSoftwarePL\PlivioSmsApiBundle\Sms\DTO\Sms;
use Plivo\RestAPI;

class PlivoSmsApiSender
{
    private $config = [];
    private $senderName;
    private $api = null;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->senderName = $config['sender'];
    }

    protected function getApi()
    {
        if (null === $this->api) {

            $this->api = new RestAPI(
                $this->config['account'],
                $this->config['token'],
                $this->config['api_url'],
                $this->config['api_version']
            );

        }
        return $this->api;
    }

    /**
     * @param Sms $sms
     * @return array
     * @throws \Exception
     */
    public function sendSms(Sms $sms)
    {
        try {

            $plivioSms = [
                'src' => $this->config['sender'],
                'dst' => $sms->phone,
                'text' => $sms->msg,
                'type' => 'sms',
                'url' => $sms->callbackUrl ?: $this->config['callbaack_url'],
                'method' => $this->config['callbaack_method']
            ];

            return $this->getApi()->send_message($plivioSms);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}