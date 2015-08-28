<?php

namespace Benoth\BoaCompra;

/**
 * Simple data validator.
 */
class DataValidator
{
    /**
     * Test if a string is non empty and shorter than a certain length.
     *
     * @param string   $string    The string to test
     * @param int|null $maxLength The string max length (or null to disable check)
     *
     * @return bool
     */
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

    /**
     * Test if a string is non empty, with only numbers and shorter than a certain length.
     *
     * @param string   $string    The string to test
     * @param int|null $maxLength The string max length (or null to disable check)
     *
     * @return bool
     */
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

    /**
     * Test if an email is valid and shorter than a certain length.
     *
     * @param string   $string    The string to test
     * @param int|null $maxLength The string max length (or null to disable check)
     *
     * @return bool
     */
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

    /**
     * Test if an URL is valid and shorter than a certain length.
     *
     * @param string   $string    The string to test
     * @param int|null $maxLength The string max length (or null to disable check)
     *
     * @return bool
     */
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

    /**
     * Test if an URL is valid, uses port 80 or 443 and shorter than a certain length.
     *
     * @param string   $string    The string to test
     * @param int|null $maxLength The string max length (or null to disable check)
     *
     * @return bool
     */
    public function validUrl($url, $maxLength = null)
    {
        return $this->nonEmptyUrl($url, $maxLength) && in_array(parse_url($url, PHP_URL_PORT), array(null, 80, 443));
    }

    /**
     * Test if a Language code is valid.
     *
     * @param string $string The string to test
     *
     * @return bool
     */
    public function validLanguage($language)
    {
        if (!in_array($language, array('pt_BR', 'es_ES', 'en_US', 'pt_PT', 'tr_TR'))) {
            return false;
        }

        return true;
    }

    /**
     * Test if a Currency code is valid.
     *
     * @param string $string The string to test
     *
     * @return bool
     */
    public function validCurrencyCode($currencyCode)
    {
        if (!in_array($currencyCode, array('ARS', 'BOB', 'BRL', 'CLP', 'COP', 'CRC', 'EUR', 'MXN', 'NIO', 'PEN', 'TRY', 'USD'))) {
            return false;
        }

        return true;
    }

    /**
     * Test if a string represent a boolean.
     *
     * @param string $string The string to test
     *
     * @return bool
     */
    public function validStringBool($bool)
    {
        if (!in_array($bool, array('0', '1'))) {
            return false;
        }

        return true;
    }

    /**
     * Test if a string is shorter than a certain length.
     *
     * @param string $string    The string to test
     * @param int    $maxLength The string max length
     *
     * @return bool
     */
    public function maxLength($string, $maxLength)
    {
        return (int) $maxLength >= mb_strlen((string) $string);
    }
}
