<?php

namespace OCSoftwarePL\PlivioSmsApiBundle\Sms;

use OCSoftwarePL\PlivioSmsApiBundle\Sms\DTO\PlivioSendResponse;
use OCSoftwarePL\PlivioSmsApiBundle\Sms\DTO\Sms;
use Plivo\RestAPI;

class PlivioSmsApiSender
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
     * @return PlivioSendResponse
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
                'url' => $sms->callbackUrl ?: $this->config['callback_url'],
                'method' => $this->config['callback_method']
            ];

            $response = $this->getApi()->send_message($plivioSms);

            return new PlivioSendResponse($response);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}