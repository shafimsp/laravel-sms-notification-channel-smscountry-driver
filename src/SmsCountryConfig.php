<?php

namespace Shafimsp\SmsNotificationChannel\SmsCountry;

use Shafimsp\SmsNotificationChannel\SmsCountry\Exceptions\SmsCountrySmsNotificationException;

class SmsCountryConfig
{
    /**
     * @var array
     */
    private $config;

    /**
     * SmsCountryConfig constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->validateCredentials();
    }

    public function getCredentials()
    {
        return [
            'User' => $this->user,
            'Passwd' => $this->password,
        ];
    }

    public function __get($name)
    {
        if ($name == 'request') {
            return $this->config['guzzle']['request'];
        }

        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
    }

    protected function validateCredentials()
    {
        if (!isset($this->config['user'], $this->config['password'])) {
            throw SmsCountrySmsNotificationException::withErrorMessage('No credentials were provided. Please set your user and password in the config file');
        }
    }
}
