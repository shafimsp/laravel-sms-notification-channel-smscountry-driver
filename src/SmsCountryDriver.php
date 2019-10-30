<?php
namespace Shafimsp\SmsNotificationChannel\SmsCountry;

use Shafimsp\SmsNotificationChannel\Drivers\Driver;
use Shafimsp\SmsNotificationChannel\SmsMessage;

class SmsCountryDriver extends Driver
{

    /**
     * The Nexmo client.
     *
     * @var SmsCountryApi
     */
    protected $client;


    /**
     * Create a new Nexmo driver instance.
     *
     * @param  SmsCountryApi $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(SmsMessage $message)
    {
        return $this->client->sendMessage($message);
    }
}