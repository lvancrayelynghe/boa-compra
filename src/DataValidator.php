<?php

namespace Benoth\BoaCompra;

class DataValidator
{
    public function nonEmptyString($string, $maxLength = null)
    {
        if (is_int($string) || is_float($string)) {
            $string = (string) $string;
        }

        if (!is_string($string) || empty($string)) {
            return false;
        }

        if (!is_null($maxLength)) {
            return $this->maxLength($string, $maxLength);
        }

        return true;
    }

    public function nonEmptyInt($int, $maxLength = null)
    {
        if (!ctype_digit($int) || empty($int)) {
            return false;
        }

        if (!is_null($maxLength)) {
            return $this->maxLength($int, $maxLength);
        }

        return true;
    }

    public function nonEmptyEmail($email, $maxLength = null)
    {
        if (!is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false || empty($email)) {
            return false;
        }

        if (!is_null($maxLength)) {
            return $this->maxLength($email, $maxLength);
        }

        return true;
    }

    public function nonEmptyUrl($url, $maxLength = null)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false || mb_substr($url, 0, 4) !== 'http') {
            return false;
        }

        if (!is_null($maxLength)) {
            return $this->maxLength($url, $maxLength);
        }

        return true;
    }

    public function validUrl($url, $maxLength = null)
    {
        return $this->nonEmptyUrl($url, $maxLength) && in_array(parse_url($url, PHP_URL_PORT), array(null, 80, 443));
    }

    public function validLanguage($language)
    {
        if (!in_array($language, array('pt_BR', 'es_ES', 'en_US', 'pt_PT', 'tr_TR'))) {
            return false;
        }

        return true;
    }

    public function validCurrencyCode($currencyCode)
    {
        if (!in_array($currencyCode, array('ARS', 'BOB', 'BRL', 'CLP', 'COP', 'CRC', 'EUR', 'MXN', 'NIO', 'PEN', 'TRY', 'USD'))) {
            return false;
        }

        return true;
    }

    public function validStringBool($bool)
    {
        if (!in_array($bool, array('0', '1'))) {
            return false;
        }

        return true;
    }

    public function maxLength($string, $maxLength)
    {
        return (int) $maxLength >= mb_strlen((string) $string);
    }
}
