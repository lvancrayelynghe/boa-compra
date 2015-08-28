<?php

namespace Benoth\BoaCompra;

/**
 * Generate the payment form to sends a payment request to BoaCompra.
 *
 * Based on documentation v2.48
 */
class PaymentFormGenerator
{
    /* Payment object */
    protected $payment;

    /* List of form keys with corresponding object and method for required values */
    protected $mappingsRequired = array(
        'store_id'          => 'vsi:getStoreId',
        'return'            => 'payment:getReturnURL',
        'notify_url'        => 'payment:getNotifyURL',
        'currency_code'     => 'payment:getCurrencyCode',
        'order_id'          => 'payment:getOrderId',
        'order_description' => 'payment:getOrderDescription',
        'amount'            => 'payment:getAmount',
        'client_email'      => 'user:getEmail',
    );

    /* List of form keys with corresponding object and method for optionnal values */
    protected $mappingsOptionnal = array(
        'project_id'        => 'payment:getProjectId',
        'payment_id'        => 'payment:getPaymentId',
        'payment_group'     => 'payment:getPaymentGroup',
        'token'             => 'payment:getToken',
        'test_mode'         => 'payment:getTestMode',
        'country_payment'   => 'payment:getCountryIso',
        'client_country'    => 'user:getCountry',
        'language'          => 'user:getLanguage',
        'client_name'       => 'user:getName',
        'client_number'     => 'user:getNumber',
        'client_street'     => 'user:getStreet',
        'client_suburb'     => 'user:getSubUrb',
        'client_zip_code'   => 'user:getZipcode',
        'client_city'       => 'user:getCity',
        'client_state'      => 'user:getState',
        'client_telephone'  => 'user:getPhone',
        'client_cpf'        => 'user:getCPF',
        'character'         => 'user:getCharacter',
    );

    /**
     * Create a new form generator.
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Render a full HTML form.
     *
     * @param string $name Form name
     *
     * @return string HTML form
     */
    public function render($name = 'boacompra-billing')
    {
        return $this->renderFormOpen($name)
            .$this->renderFormContent()
            .$this->renderFormClose();
    }

    /**
     * Render a HTML form open tag.
     *
     * @param string $name   Form name
     *
     * @return string HTML form open tag
     */
    public function renderFormOpen($name = 'boacompra-billing')
    {
        return '<form method="POST" name="'.$name.'" action="'.$this->payment->getBillingURL().'">'.PHP_EOL;
    }

    /**
     * Render the BoaCompra HTML form content (list of inputs hidden).
     *
     * @return string HTML inputs hidden
     */
    public function renderFormContent()
    {
        $content = '';

        // Required fields
        foreach ($this->mappingsRequired as $fieldName => $methodKey) {
            $content .= $this->renderHiddenInput($fieldName, $this->callMethod($methodKey));
        }

        // Add the MD5 hash key
        $content .= $this->renderHiddenInput('hash_key', $this->generateHashKey());

        // Optionnal fields
        foreach ($this->mappingsOptionnal as $fieldName => $methodKey) {
            $value = $this->callMethod($methodKey);
            if (!is_null($value)) {
                $content .= $this->renderHiddenInput($fieldName, $value);
            }
        }

        return $content;
    }

    /**
     * Render a HTML form close tag.
     *
     * @return string HTML form close tag
     */
    public function renderFormClose()
    {
        return '</form>'.PHP_EOL;
    }

    /**
     * Render a HTML input hidden field.
     *
     * @param string $name  Field name
     * @param string $value Field value
     *
     * @return string HTML input hidden field
     */
    protected function renderHiddenInput($name, $value)
    {
        return "\t".'<input type="hidden" name="'.$name.'" value="'.trim($value).'">'.PHP_EOL;
    }

    /**
     * Call a method on an object by a special key.
     *
     * ie: payment:getOrderId will call $this->payment->getOrderId()
     *
     * @param string $key Method key
     *
     * @return mixed Called method return
     */
    protected function callMethod($key)
    {
        if (!is_string($key) || substr_count($key, ':') !== 1) {
            throw new \Exception('Invalid method "'.$key.'"');
        }

        list($object, $method) = explode(':', $key);
        if ($object === 'vsi') {
            return $this->payment->getVirtualStoreIdentification()->{$method}();
        } elseif ($object === 'user') {
            return $this->payment->getEndUser()->{$method}();
        } elseif ($object === 'payment') {
            return $this->payment->{$method}();
        }

        throw new \Exception('Invalid method "'.$key.'"');
    }

    /**
     * Generate the MD5 between important parameters of the form and a Key defined by Virtual Store.
     *
     * @return string The MD5 key
     */
    protected function generateHashKey()
    {
        return md5(
            $this->payment->getVirtualStoreIdentification()->getStoreId()
            .$this->payment->getNotifyURL()
            .$this->payment->getOrderId()
            .$this->payment->getAmount()
            .$this->payment->getCurrencyCode()
            .$this->payment->getVirtualStoreIdentification()->getKey()
        );
    }
}
