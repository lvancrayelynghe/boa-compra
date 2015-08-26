<?php namespace Benoth\BoaCompra;

/**
 * Generate the payment to sends a payment request to BoaCompra
 *
 * Based on documentation v2.48
 */
class Payment
{
    use PropertyValidateAffect;

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
        $this->validator = new DataValidator();
        $this->ident     = $ident;
        $this->endUser   = $endUser;

        $this->affectProperty('returnUrl', $returnUrl, 'nonEmptyUrl', 200);
        $this->affectProperty('notifyUrl', $notifyUrl, 'validUrl', 200);
        $this->affectProperty('currencyCode', $currencyCode, 'validCurrencyCode', 200);
        $this->affectProperty('orderId', $orderId, 'nonEmptyString', 30);
        $this->affectProperty('orderDescription', $orderDescription, 'nonEmptyString', 200);
        $this->affectProperty('amount', $amount, 'nonEmptyInt', 7);
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
        return $this->affectProperty('countryIso', $countryIso, 'nonEmptyString', 2);
    }

    public function setProjectId($projectId)
    {
        return $this->affectProperty('projectId', $projectId, 'nonEmptyString', 6);
    }

    public function setPaymentId($paymentId)
    {
        return $this->affectProperty('paymentId', $paymentId, 'nonEmptyString', 6);
    }

    public function setPaymentGroup($paymentGroup)
    {
        return $this->affectProperty('paymentGroup', $paymentGroup, 'nonEmptyString', 20);
    }

    public function setToken($token)
    {
        return $this->affectProperty('token', $token, 'nonEmptyString', 32);
    }

    public function setTestMode($testMode)
    {
        return $this->affectProperty('testMode', $testMode, 'validStringBool');
    }
}
