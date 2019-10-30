<?php

namespace Shafimsp\SmsNotificationChannel\SmsCountry\Exceptions;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Shafimsp\SmsNotificationChannel\Exceptions\SmsException;

class SmsCountrySmsNotificationException extends SmsException
{
    /**
     * Thrown when SMS Country return a response body other than '1'.
     *
     * @param $code
     * @param $message
     *
     * @return static
     */
    public static function respondedWithAnError($code, $message)
    {
        return new static(
            sprintf("SMS Country responded with error number %s and message:\n%s",
                $code,
                $message
            ));
    }

    /**
     * Thrown when GuzzleHttp throw a request exception.
     *
     * @param RequestException $exception
     *
     * @return static
     */
    public static function couldNotSendRequest(RequestException $exception)
    {
        return new static(
            'Request to SMS Country failed',
            $exception->getCode(),
            $exception
        );
    }

    /**
     * Thrown when any other errors received.
     *
     * @param ResponseInterface $response
     *
     * @return static
     */
    public static function someErrorWhenSendingSms(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $message = (string)$response->getBody();

        return new static(
            sprintf('Could not send sms notification to SMS Country. Status code %s and message: %s', $code, $message)
        );
    }

    /**
     * Thrown when any other errors occur.
     *
     * @param $message
     *
     * @return static
     */
    public static function withErrorMessage($message)
    {
        return new static($message);
    }
}
