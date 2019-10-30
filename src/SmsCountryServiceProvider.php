<?php

namespace Shafimsp\SmsNotificationChannel\SmsCountry;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Shafimsp\SmsNotificationChannel\Facades\Sms;
use Shafimsp\SmsNotificationChannel\SmsCountry\Exceptions\SmsCountrySmsNotificationException;
use Shafimsp\SmsNotificationChannel\SmsManager;

class SmsCountryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Sms::resolved(function (SmsManager $service) {
            $service->extend('smscountry', function ($app) {
                $smsCountryConfig = $this->app['config']['services.smscountry'];
                if (empty($smsCountryConfig)) {
                    throw SmsCountrySmsNotificationException::withErrorMessage('Config for SMS Country not found in service.');
                }

                return new SmsCountryDriver(
                    new SmsCountryApi(
                        new SmsCountryConfig($smsCountryConfig),
                        new Client(
                            $smsCountryConfig['guzzle']['client']
                        )
                    )
                );
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

}
