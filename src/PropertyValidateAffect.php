<?php

namespace Benoth\BoaCompra;

trait PropertyValidateAffect
{
    /**
     * DataValidator instance.
     *
     * @type \Benoth\BoaCompra\DataValidator
     */
    protected $validator;

    /**
     * Affect a property if a certain validation rule succeed.
     * Throws an Exception otherwise.
     *
     * @param string $property         Property name
     * @param mixed  $value            Value to affect
     * @param string $validationMethod Rule
     * @param mixed  $maxLength        Max length for strings
     *
     * @return mixed Current object
     */
    protected function affectProperty($property, $value, $validationMethod, $maxLength = null)
    {
        if (!is_null($maxLength) && !$this->validator->{$validationMethod}($value, $maxLength)) {
            throw new \Exception('Invalid '.$property.'. Must be '.$validationMethod.' (max length of '.$maxLength.')');
        } elseif (is_null($maxLength) && !$this->validator->{$validationMethod}($value)) {
            throw new \Exception('Invalid '.$property.'. Must be '.$validationMethod);
        }

        $this->{$property} = $value;

        return $this;
    }
}
