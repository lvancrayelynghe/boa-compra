<?php namespace Benoth\BoaCompra;

trait PropertyValidateAffect
{
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
