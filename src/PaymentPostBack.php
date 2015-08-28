<?php

namespace Benoth\BoaCompra;

/**
 * Send the postback to BoaCompra to confirm the order once the notification is received.
 *
 * Based on documentation v2.48
 */
class PaymentPostBack
{
    /* BoaCompra Billing URL - must be sent through a POST method */
    const POSTBACK_URL      = 'https://billing.boacompra.com/boacompra.php';
    const POSTBACK_TEST_URL = 'https://billing.boacompra.com/boacompra_test.php';

    /* PaymentNotification received from BoaCompra */
    protected $notification;

    /* List of BoaCompra error codes and equivalent message */
    protected $errorCodes = array(
        2 => 'Incorrect parameters values',
        3 => 'Order not found',
        4 => 'Postback is missing data',
        5 => 'Order not paid yet',
        6 => 'Error reported by the Virtual Store',
        7 => 'Value for "hash_key" parameter is incorrect',
        9 => 'Wrong postback url. Please check the "Test Environment" section',
    );

    /**
     * Create the PaymentPostBack.
     *
     * @param PaymentNotification $notification Previously received Notification
     */
    public function __construct(PaymentNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the Notification object.
     *
     * @return PaymentNotification
     */
    public function getPaymentNotification()
    {
        return $this->notification;
    }

    /**
     * Validate the payment.
     *
     * @throws Exception Reason of the error if the payment is not valid
     *
     * @return bool True on success
     */
    public function validatePayment()
    {
        $code = $this->getReturnCode();
        if ($code === 0 || $code === 1) {
            // 0 - Order successfully confirmed.
            // 1 - Order already confirmed.
            return true;
        }

        throw new \Exception($this->getErrorCodeMessage($code), (int) $code);
    }

    /**
     * Get the error code corresponding message.
     *
     * @param int $code
     *
     * @return string The error message
     */
    protected function getErrorCodeMessage($code)
    {
        if (array_key_exists($code, $this->errorCodes)) {
            return $this->errorCodes[$code];
        }

        return 'Unknown return code "'.$code.'"';
    }

    /**
     * Get the POST fields to be sent to BoaCompra.
     *
     * @return array
     */
    protected function getPostFields()
    {
        $fields = array(
            'store_id'         => $this->notification->getPayment()->getVirtualStoreIdentification()->getStoreId(),
            'transaction_id'   => $this->notification->getTransactionId(),
            'order_id'         => $this->notification->getPayment()->getOrderId(),
            'amount'           => $this->notification->getPayment()->getAmount(),
            'currency_code'    => $this->notification->getCurrencyCode(),
            'payment_id'       => $this->notification->getPaymentId(),
            'country_payment'  => $this->notification->getPayment()->getCountryIso(),
            'customer_country' => $this->notification->getPayment()->getEndUser()->getCountry(),
            'cmd'              => '_code-notify',
            'hash_key'         => $this->generateHashKey(),
        );

        return $fields;
    }

    /**
     * Generate the BoaCompra MD5 security Hash Key.
     *
     * @return string
     */
    protected function generateHashKey()
    {
        return md5(
            $this->notification->getPayment()->getVirtualStoreIdentification()->getStoreId().
            $this->notification->getTransactionId().
            $this->notification->getPayment()->getOrderId().
            $this->notification->getPayment()->getAmount().
            $this->notification->getCurrencyCode().
            $this->notification->getPayment()->getVirtualStoreIdentification()->getKey()
        );
    }

    /**
     * Get the BoaCompra URL to be used for the post back.
     *
     * @return string
     */
    protected function getURL()
    {
        if ($this->notification->getPayment()->getTestMode()) {
            return static::POSTBACK_TEST_URL;
        }

        return static::POSTBACK_URL;
    }

    /**
     * Run the CURL request to send the post back to BoaCompra.
     *
     * @return array Results of curl_exec() and curl_getinfo()
     */
    protected function curlRequest()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getURL());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getPostFields());
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        $infos    = curl_getinfo($curl);
        curl_close($curl);

        return array($response, $infos);
    }

    /**
     * Get the BoaCompra Response and chek if the return code is present.
     *
     * @throws Exception If no return code found
     *
     * @return array Results of curl_exec() and curl_getinfo()
     */
    protected function getResponse()
    {
        list($response, $infos) = $this->curlRequest();

        if (mb_strlen($response) === 0) {
            throw new \Exception('Empty response (HTTP response code : '.$infos['http_code'].')');
        }

        if (strpos($response, 'CODRET') === false || mb_strlen($response) < 8) {
            throw new \Exception('No return code provided (HTTP response code : '.$infos['http_code'].')');
        }

        return array($response, $infos);
    }

    /**
     * Get the BoaCompra Return code.
     *
     * @return int
     */
    protected function getReturnCode()
    {
        list($response) = $this->getResponse();

        return (int) str_replace('CODRET=', '', trim($response));
    }
}
