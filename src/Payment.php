<?php namespace Benoth\BoaCompra;

/**
 * Generate the payment to sends a payment request to BoaCompra
 *
 * Based on documentation v2.48
 */
class Payment
{
    /* BoaCompra Billing URL - must be sent through a POST method */
    const BILLING_URL = 'https://billing.boacompra.com/payment.php';

    /* VirtualStoreIdentification object */
    protected $ident;

    /* EndUser object */
    protected $endUser;

    /* URL used to redirect end users in successful transactions. (max length 200) (REQUIRED) */
    protected $returnUrl;

    /* URL used to notify the Virtual Store (This URL must bind ports 80 or 443) (max length 200) (REQUIRED) */
    protected $notifyUrl;

    /* Order currency ISO code (Possible values ARS,BOB,BRL,CLP,COP,CRC,EUR,MXN,NIO,PEN,TRY,USD) (REQUIRED) */
    protected $currencyCode;

    /* Order Identification on Virtual Store (This must be an unique value) (max length 30) (REQUIRED) */
    protected $orderId;

    /* Small description of the order (max length 200) (REQUIRED) */
    protected $orderDescription;

    /* Order's total amount (without commas or dots) (max length 7) (REQUIRED) */
    protected $amount;

    /* ISO Code of the country from which the payment methods must be displayed without
    showing the country selection page to the End User (max length 2) */
    protected $countryIso;

    /* Project Identifier (max length 6) */
    protected $projectId;

    /* Payment Identifier. This parameter is used to show a specific payment method to the final user (max length 6) */
    protected $paymentId;

    /* Payment group name. This parameter is used to show a
    specific group of payment methods to the End User (max length 20) */
    protected $paymentGroup;

    /* Access token provided by external partner for authentication.
    Please contact your Account Manager for further information (max length 32) */
    protected $token;

    /* Parameter used to indicate that a transaction will be processed in test mode.
    Can be used the value "1" to test integration and "0" to production environment. */
    protected $testMode;

    public function __construct(VirtualStoreIdentification $ident, EndUser $endUser, $returnUrl, $notifyUrl, $currencyCode, $orderId, $orderDescription, $amount)
    {
        if (!$this->validateUrl($returnUrl)) {
            throw new \Exception('Invalid return URL provided (scheme must be HTTP(s) must be valid and max length of 200)');
        }

        if (!$this->validateUrl($notifyUrl)) {
            throw new \Exception('Invalid notify URL provided (scheme must be HTTP(s) must be valid and max length of 200)');
        }

        if (!in_array(parse_url($notifyUrl, PHP_URL_PORT), array(null, 80, 443))) {
            throw new \Exception('Invalid notify URL provided (must use port 80 or 443)');
        }

        if (!in_array($currencyCode, array('ARS', 'BOB', 'BRL', 'CLP', 'COP', 'CRC', 'EUR', 'MXN', 'NIO', 'PEN', 'TRY', 'USD'))) {
            throw new \Exception('Invalid currency code provided. Possible values are ARS,BOB,BRL,CLP,COP,CRC,EUR,MXN,NIO,PEN,TRY,USD');
        }

        if (empty($orderId)) {
            throw new \Exception('Order ID must be provided');
        }

        if (mb_strlen($orderId) > 30) {
            throw new \Exception('Order ID must have a max length of 30');
        }

        if (empty($orderDescription)) {
            throw new \Exception('Order description must be provided');
        }

        if (mb_strlen($orderDescription) > 200) {
            throw new \Exception('Order description must have a max length of 200');
        }

        if (empty($amount)) {
            throw new \Exception('Order amount must be provided');
        }

        if (!ctype_digit($amount) or mb_strlen((string) $amount) > 7) {
            throw new \Exception('Order amount must be an integer (amount without commas or dots) with max length of 7');
        }

        $this->ident            = $ident;
        $this->endUser          = $endUser;
        $this->returnUrl        = $returnUrl;
        $this->notifyUrl        = $notifyUrl;
        $this->currencyCode     = $currencyCode;
        $this->orderId          = $orderId;
        $this->orderDescription = $orderDescription;
        $this->amount           = $amount;
    }

    public function getBillingURL()
    {
        return static::BILLING_URL;
    }

    public function getVirtualStoreIdentification()
    {
        return $this->ident;
    }

    public function getEndUser()
    {
        return $this->endUser;
    }

    public function getReturnURL()
    {
        return $this->returnUrl;
    }

    public function getNotifyURL()
    {
        return $this->notifyUrl;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getOrderDescription()
    {
        return $this->orderDescription;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCountryIso()
    {
        return $this->countryIso;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function getPaymentGroup()
    {
        return $this->paymentGroup;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getTestMode()
    {
        return $this->testMode;
    }

    public function setCountryIso($countryIso)
    {
        if (!is_string($countryIso) or empty($countryIso) or mb_strlen($countryIso) > 2) {
            throw new \Exception('Invalid country iso code. Must be a non-empty string with max length of 2');
        }

        $this->countryIso = $countryIso;

        return $this;
    }

    public function setProjectId($projectId)
    {
        if (!is_string($projectId) or empty($projectId) or mb_strlen($projectId) > 6) {
            throw new \Exception('Invalid project ID. Must be a non-empty string with max length of 6');
        }

        $this->projectId = $projectId;

        return $this;
    }

    public function setPaymentId($paymentId)
    {
        if (!is_string($paymentId) or empty($paymentId) or mb_strlen($paymentId) > 6) {
            throw new \Exception('Invalid payment ID. Must be a non-empty string with max length of 6');
        }

        $this->paymentId = $paymentId;

        return $this;
    }

    public function setPaymentGroup($paymentGroup)
    {
        if (!is_string($paymentGroup) or empty($paymentGroup) or mb_strlen($paymentGroup) > 20) {
            throw new \Exception('Invalid payment group. Must be a non-empty string with max length of 20');
        }

        $this->paymentGroup = $paymentGroup;

        return $this;
    }

    public function setToken($token)
    {
        if (!is_string($token) or empty($token) or mb_strlen($token) > 32) {
            throw new \Exception('Invalid external partner token. Must be a non-empty string with max length of 32');
        }

        $this->token = $token;

        return $this;
    }

    public function setTestMode($testMode)
    {
        if (!in_array($testMode, array(0, 1, '0', '1'))) {
            throw new \Exception('Invalid test mode. Valid values are 0 or 1');
        }

        $this->testMode = $testMode;

        return $this;
    }

    protected function validateUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false or mb_substr($url, 0, 4) !== 'http' or mb_strlen($url) > 200) {
            return false;
        }

        return true;
    }
}
