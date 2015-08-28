<?php

namespace Benoth\BoaCompra;

/**
 * BoaCompra End User.
 *
 * Based on documentation v2.48
 */
class EndUser
{
    use PropertyValidateAffect;

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

    /**
     * Create a new End User.
     *
     * @param string $email End User email address
     *
     * @throws Exception If the provided email is not a valid email address
     */
    public function __construct($email)
    {
        $this->validator = new DataValidator();

        $this->affectProperty('email', $email, 'nonEmptyEmail', 60);
    }

    /**
     * Get the End User Email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the End User Full name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the End User Address number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the End User Address / Street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Get the End User SubUrb.
     *
     * @return string
     */
    public function getSubUrb()
    {
        return $this->suburb;
    }

    /**
     * Get the End User Postal code.
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Get the End User City.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the End User State.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the End User Country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the End User Phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the End User CPF.
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->cpf;
    }

    /**
     * Get the End User Language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the End User Character name or Player login.
     *
     * @return string
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set the End User Full name (max length 60)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $name
     *
     * @throws Exception If the provided entry is empty or more than 60 characters
     *
     * @return EndUser This
     */
    public function setName($name)
    {
        return $this->affectProperty('name', $name, 'nonEmptyString', 60);
    }

    /**
     * Set the End User Address number (max length 10).
     *
     * @param string $number
     *
     * @throws Exception If the provided entry is empty or more than 10 characters
     *
     * @return EndUser This
     */
    public function setNumber($number)
    {
        return $this->affectProperty('number', $number, 'nonEmptyString', 10);
    }

    /**
     * Set the End User Address / Street (max length 60).
     *
     * @param string $street
     *
     * @throws Exception If the provided entry is empty or more than 60 characters
     *
     * @return EndUser This
     */
    public function setStreet($street)
    {
        return $this->affectProperty('street', $street, 'nonEmptyString', 60);
    }

    /**
     * Set the End User Suburb (max length 60).
     *
     * @param string $suburb
     *
     * @throws Exception If the provided entry is empty or more than 60 characters
     *
     * @return EndUser This
     */
    public function setSubUrb($suburb)
    {
        return $this->affectProperty('suburb', $suburb, 'nonEmptyString', 60);
    }

    /**
     * Set the End Postal code (numbers only) (max length 8).
     *
     * @param string $zipcode
     *
     * @throws Exception If the provided entry is empty, contains not only number or more than 8 characters
     *
     * @return EndUser This
     */
    public function setZipcode($zipcode)
    {
        return $this->affectProperty('zipcode', $zipcode, 'nonEmptyInt', 8);
    }

    /**
     * Set the End User City (max length 20)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $city
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return EndUser This
     */
    public function setCity($city)
    {
        return $this->affectProperty('city', $city, 'nonEmptyString', 20);
    }

    /**
     * Set the End User State (max length 20)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $state
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return EndUser This
     */
    public function setState($state)
    {
        return $this->affectProperty('state', $state, 'nonEmptyString', 20);
    }

    /**
     * Set the End User Country (max length 20)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $country
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return EndUser This
     */
    public function setCountry($country)
    {
        return $this->affectProperty('country', $country, 'nonEmptyString', 20);
    }

    /**
     * Set the End User Phone Number (max length 20)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $phone
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return EndUser This
     */
    public function setPhone($phone)
    {
        return $this->affectProperty('phone', $phone, 'nonEmptyString', 20);
    }

    /**
     * Set the End User CPF (for Brazil only) (max length 20)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $cpf
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return EndUser This
     */
    public function setCPF($cpf)
    {
        return $this->affectProperty('cpf', $cpf, 'nonEmptyString', 20);
    }

    /**
     * Set the End User Language (max length 5)
     * Valid values : pt_BR, es_ES, en_US, pt_PT, tr_TR.
     *
     * @param string $language
     *
     * @throws Exception If the provided entry doesn't match a valid value
     *
     * @return EndUser This
     */
    public function setLanguage($language)
    {
        return $this->affectProperty('language', $language, 'validLanguage');
    }

    /**
     * Set the End User Character name or Player login (max length 100)
     * Provides anti-fraud analysis and semi-transparent checkout.
     *
     * @param string $character
     *
     * @throws Exception If the provided entry is empty or more than 100 characters
     *
     * @return EndUser This
     */
    public function setCharacter($character)
    {
        return $this->affectProperty('character', $character, 'nonEmptyString', 100);
    }
}
