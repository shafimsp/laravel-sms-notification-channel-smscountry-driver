# SMS Country Driver For Laravel SMS Notification Channel

## Installation

To install the PHP client library using Composer:

```bash
composer require shafimsp/laravel-sms-notification-channel-smscountry-driver
```

The package will automatically register itself.

## Driver Prerequisites

SMS Country is API based driver, this require the Guzzle HTTP library, which may be installed via the composer package manager:

```bash
composer require composer require guzzlehttp/guzzle
```

## SMS Country Driver

To use the SMS Country driver, first install Guzzle, then set the driver option in your  config/services.php configuration file to SMS Country. Next, verify that your config/services.php configuration file contains the following options:

```php
    'smscountry' => [
        // Set yor login credentials to communicate with mobily.ws Api
        'user' => env('SMS_COUNTRY_USER', ''),
        'password' => env('SMS_COUNTRY_PASSWORD', ''),

        'sms_from' => env('SMS_FROM', ''),

        /*
        |--------------------------------------------------------------------------
        | Define options for the Http request. (Guzzle http client options)
        |--------------------------------------------------------------------------
        |
        | You do not need to change any of these settings.
        |
        |
        */
        'guzzle' => [
            'client' => [
                // The Base Uri of the Api. Don't Change this Value.
                'base_uri' => 'http://api.smscountry.com/',
            ],

            // Request Options. http://docs.guzzlephp.org/en/stable/request-options.html
            'request' => [
                'http_errors' => true,
                // For debugging
                'debug' => false,
            ],
        ],
    ]
```

## License

SMS Country SMS Notification Driver is open-sourced software licensed under the [MIT license](LICENSE.md).