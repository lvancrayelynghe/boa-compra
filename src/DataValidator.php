<?php namespace Benoth\BoaCompra;

class DataValidator
{
    public function nonEmptyString($string, $maxLength = null)
    {
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

    public function maxLength($string, $maxLength)
    {
        return (int) $maxLength >= mb_strlen((string) $string);
    }
}
