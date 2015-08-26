<?php namespace Benoth\BoaCompra;

/**
 * BoaCompra End User
 *
 * Based on documentation v2.48
 */
class EndUser
{
    use PropertyValidateAffect;

    /* DataValidator object */
    protected $validator;

    /* End user email (max length 60) (REQUIRED) */
    protected $email;

    /* End User full name (max length 60) */
    protected $name;

    /* End User address number (max length 10) */
    protected $number;

    /* End User address (max length 60) */
    protected $street;

    /* End User suburb (max length 60) */
    protected $suburb;

    /* End User postal code (numbers only) (max length 8) */
    protected $zipcode;

    /* End User City (max length 60) (provides anti-fraud analysis and semi-transparent checkout) */
    protected $city;

    /* End User State (max length 30) (provides anti-fraud analysis and semi-transparent checkout) */
    protected $state;

    /* End User Country (max length 20) (provides anti-fraud analysis and semi-transparent checkout) */
    protected $country;

    /* End User Phone Number (max length 20) (provides anti-fraud analysis and semi-transparent checkout) */
    protected $phone;

    /* End User CPF (For Brazil only) (max length 20) (provides anti-fraud analysis and semi-transparent checkout) */
    protected $cpf;

    /* Default Language. Possible values pt_BR, es_ES, en_US, pt_PT, tr_TR */
    protected $language;

    /* Character or player login (max length 100) */
    protected $character;

    public function __construct($email)
    {
        $this->validator = new DataValidator();

        $this->affectProperty('email', $email, 'nonEmptyEmail', 60);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getSubUrb()
    {
        return $this->suburb;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getCPF()
    {
        return $this->cpf;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getCharacter()
    {
        return $this->character;
    }

    public function setName($name)
    {
        return $this->affectProperty('name', $name, 'nonEmptyString', 60);
    }

    public function setNumber($number)
    {
        return $this->affectProperty('number', $number, 'nonEmptyString', 10);
    }

    public function setStreet($street)
    {
        return $this->affectProperty('street', $street, 'nonEmptyString', 60);
    }

    public function setSubUrb($suburb)
    {
        return $this->affectProperty('suburb', $suburb, 'nonEmptyString', 60);
    }

    public function setZipcode($zipcode)
    {
        return $this->affectProperty('zipcode', $zipcode, 'nonEmptyInt', 8);
    }

    public function setCity($city)
    {
        return $this->affectProperty('city', $city, 'nonEmptyString', 20);
    }

    public function setState($state)
    {
        return $this->affectProperty('state', $state, 'nonEmptyString', 20);
    }

    public function setCountry($country)
    {
        return $this->affectProperty('country', $country, 'nonEmptyString', 20);
    }

    public function setPhone($phone)
    {
        return $this->affectProperty('phone', $phone, 'nonEmptyString', 20);
    }

    public function setCPF($cpf)
    {
        return $this->affectProperty('cpf', $cpf, 'nonEmptyString', 20);
    }

    public function setLanguage($language)
    {
        return $this->affectProperty('language', $language, 'validLanguage');
    }

    public function setCharacter($character)
    {
        return $this->affectProperty('character', $character, 'nonEmptyString', 100);
    }
}
