<?php

namespace Shafimsp\SmsNotificationChannel\SmsCountry;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;
use Shafimsp\SmsNotificationChannel\SmsCountry\Exceptions\SmsCountrySmsNotificationException;
use Shafimsp\SmsNotificationChannel\SmsMessage;

class SmsCountryApi
{

    /**  @var string SmsCountry endpoint for sending sms */
    protected $endpoint = 'SMSCwebservice_bulk.aspx';

    /** @var SmsCountryConfig */
    private $config;

    /** @var HttpClient */
    private $http;

    /**
     * Create a new SmsCountry channel instance.
     *
     * @param SmsCountryConfig $config
     * @param HttpClient $http
     */
    public function __construct(SmsCountryConfig $config, HttpClient $http)
    {
        $this->http = $http;
        $this->config = $config;
    }

    /**
     * Send request with string message
     *
     * @param $params
     *
     * @return array
     */
    public function sendString($params)
    {
        $payload = $this->preparePayload($params);
        return $this->send($payload);
    }

    /**
     * Send request with SmsMessage instance
     *
     * @param SmsMessage $message
     *
     * @return array
     */
    public function sendMessage(SmsMessage $message)
    {
        $params = [
            'Message' => $message->content,
            'Mobilenumber' => implode(',', $message->to ?: []),
            'Mtype' => $message->type == 'unicode' ? 'LNG' : 'N',
            'SMS_Job_NO' => $message->clientReference
        ];

        $payload = $this->preparePayload($params);

        return $this->send($payload);
    }

    /**
     * Send request to SMS Country
     *
     * @param array $payload
     *
     * @return array
     * @throws \Shafimsp\SmsNotificationChannel\SmsCountry\Exceptions\SmsCountrySmsNotificationException
     * @internal param array $params
     *
     */
    public function send(array $payload)
    {
        try {
            $response = $this->http->get($this->endpoint, $payload);

            if ($response->getStatusCode() != 200) {
                throw SmsCountrySmsNotificationException::someErrorWhenSendingSms($response);
            }

            $message = (string)$response->getBody();

            if (!Str::startsWith($message, "OK")) {
                throw SmsCountrySmsNotificationException::someErrorWhenSendingSms($response);
            }

            return $message;
        } catch (RequestException $exception) {
            throw SmsCountrySmsNotificationException::couldNotSendRequest($exception);
        }
    }

    /**
     * Prepare payload for http request.
     *
     * @param $params
     *
     * @return array
     */
    protected function preparePayload($params)
    {
        $form = array_merge([
            'Sid' => $this->config->sms_from,
            'DR' => 'Y',
        ], $params, $this->config->getCredentials());

        return array_merge(
            ['form_params' => $form],
            $this->config->request
        );
    }
}
