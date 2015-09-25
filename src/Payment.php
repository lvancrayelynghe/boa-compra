<?php

namespace Benoth\BoaCompra;

/**
 * Generate the payment to sends a payment request to BoaCompra.
 *
 * Based on documentation v2.48
 */
class Payment
{
    use PropertyValidateAffect;

    /** BoaCompra Billing URL - must be sent through a POST method **/
    const BILLING_URL = 'https://billing.boacompra.com/payment.php';

    /**
     * VirtualStoreIdentification object.
     *
     * @type \Benoth\BoaCompra\VirtualStoreIdentification
     */
    protected $ident;

    /**
     * EndUser object.
     *
     * @type \Benoth\BoaCompra\EndUser
     */
    protected $endUser;

    /** URL used to redirect end users in successful transactions. (max length 200) (REQUIRED) **/
    protected $returnUrl;

    /** URL used to notify the Virtual Store (This URL must bind ports 80 or 443) (max length 200) (REQUIRED) **/
    protected $notifyUrl;

    /** Order currency ISO code (Possible values ARS,BOB,BRL,CLP,COP,CRC,EUR,MXN,NIO,PEN,TRY,USD) (REQUIRED) **/
    protected $currencyCode;

    /** Order Identification on Virtual Store (This must be an unique value) (max length 30) (REQUIRED) **/
    protected $orderId;

    /** Small description of the order (max length 200) (REQUIRED) **/
    protected $orderDescription;

    /** Order's total amount (without commas or dots) (max length 7) (REQUIRED) **/
    protected $amount;

    /** ISO Code of the country from which the payment methods must be displayed without showing the country selection page to the End User (max length 2) **/
    protected $countryIso;

    /** Project Identifier (max length 6) **/
    protected $projectId;

    /** Payment Identifier. This parameter is used to show a specific payment method to the final user (max length 6) **/
    protected $paymentId;

    /** Payment group name. This parameter is used to show a specific group of payment methods to the End User (max length 20) **/
    protected $paymentGroup;

    /** Access token provided by external partner for authentication.
     *  Contact your Account Manager for further information (max length 32).
     */
    protected $token;

    /** Parameter used to indicate that a transaction will be processed in test mode.
     *  Can be used the value "1" to test integration and "0" to production environment.
     */
    protected $testMode;

    /**
     * Create a new Payment.
     *
     * @param VirtualStoreIdentification $ident            VirtualStoreIdentification object
     * @param EndUser                    $endUser          EndUser object
     * @param string                     $returnUrl        URL used to redirect end users in successful transactions (max length 200)
     * @param string                     $notifyUrl        URL used to notify the Virtual Store (This URL must bind ports 80 or 443) (max length 200)
     * @param string                     $currencyCode     Order currency ISO code (Possible values ARS,BOB,BRL,CLP,COP,CRC,EUR,MXN,NIO,PEN,TRY,USD)
     * @param string                     $orderId          Order Identification on Virtual Store (This must be an unique value) (max length 30)
     * @param string                     $orderDescription Small description of the order (max length 200)
     * @param string                     $amount           Order's total amount (without commas or dots) (max length 7)
     *
     * @throws Exception If one of the provided parameters is out of bounds (see parameters description)
     */
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

    /**
     * Get the BoaCompra Billing URL.
     *
     * @return string
     */
    public function getBillingURL()
    {
        return static::BILLING_URL;
    }

    /**
     * Get the Virtual Store Identification.
     *
     * @return VirtualStoreIdentification
     */
    public function getVirtualStoreIdentification()
    {
        return $this->ident;
    }

    /**
     * Get the End User.
     *
     * @return EndUser
     */
    public function getEndUser()
    {
        return $this->endUser;
    }

    /**
     * Get the Virtual Store URL used to redirect end users in successful transactions.
     *
     * @return string
     */
    public function getReturnURL()
    {
        return $this->returnUrl;
    }

    /**
     * Get the Virtual Store URL used by BoaCompra to notify a new payment.
     *
     * @return string
     */
    public function getNotifyURL()
    {
        return $this->notifyUrl;
    }

    /**
     * Get the Currency code.
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Get the Order Id.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Get the Order description.
     *
     * @return string
     */
    public function getOrderDescription()
    {
        return $this->orderDescription;
    }

    /**
     * Get the Amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the Country ISO.
     *
     * @return string
     */
    public function getCountryIso()
    {
        return $this->countryIso;
    }

    /**
     * Get the Project ID.
     *
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Get the Payment ID (payment method).
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Get the Payment Group (used to show a specific group of payment methods to the End User).
     *
     * @return string
     */
    public function getPaymentGroup()
    {
        return $this->paymentGroup;
    }

    /**
     * Get the Access token provided by external partner for authentication.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the Test mode (0 = Prod, 1 = Test).
     *
     * @return string
     */
    public function getTestMode()
    {
        return $this->testMode;
    }

    /**
     * Set the ISO Code of the country from which the payment methods must be displayed without
     * showing the country selection page to the End User (max length 2).
     *
     * @param string $countryIso
     *
     * @throws Exception If the provided entry is empty or more than 2 characters
     *
     * @return Payment This
     */
    public function setCountryIso($countryIso)
    {
        return $this->affectProperty('countryIso', $countryIso, 'nonEmptyString', 2);
    }

    /**
     * Set the Project Identifier (max length 6).
     *
     * @param string $projectId
     *
     * @throws Exception If the provided entry is empty or more than 6 characters
     *
     * @return Payment This
     */
    public function setProjectId($projectId)
    {
        return $this->affectProperty('projectId', $projectId, 'nonEmptyString', 6);
    }

    /**
     * Set the Payment Identifier (max length 6)
     * This parameter is used to show a specific payment method to the final user.
     *
     * @param string $paymentId
     *
     * @throws Exception If the provided entry is empty or more than 6 characters
     *
     * @return Payment This
     */
    public function setPaymentId($paymentId)
    {
        return $this->affectProperty('paymentId', $paymentId, 'nonEmptyString', 6);
    }

    /**
     * Set the Payment group name (max length 20)
     * This parameter is used to show a specific group of payment methods to the End User.
     *
     * @param string $paymentGroup
     *
     * @throws Exception If the provided entry is empty or more than 20 characters
     *
     * @return Payment This
     */
    public function setPaymentGroup($paymentGroup)
    {
        return $this->affectProperty('paymentGroup', $paymentGroup, 'nonEmptyString', 20);
    }

    /**
     * Set the Access token provided by external partner for authentication (max length 32)
     * Please contact your Account Manager for further information.
     *
     * @param string $token
     *
     * @throws Exception If the provided entry is empty or more than 32 characters
     *
     * @return Payment This
     */
    public function setToken($token)
    {
        return $this->affectProperty('token', $token, 'nonEmptyString', 32);
    }

    /**
     * Parameter used to indicate that a transaction will be processed in test mode (valid values : 0 / 1)
     * Can be used the value "1" to test integration and "0" to production environment.
     *
     * @param string $testMode
     *
     * @throws Exception If the provided entry is different than 0 or 1
     *
     * @return Payment This
     */
    public function setTestMode($testMode)
    {
        return $this->affectProperty('testMode', $testMode, 'validStringBool');
    }
}
