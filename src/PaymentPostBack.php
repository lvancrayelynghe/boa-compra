<?php namespace Benoth\BoaCompra;

/**
 * Send the postback to BoaCompra to confirm the order information
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

    public function __construct(PaymentNotification $notification)
    {
        $this->notification = $notification;
    }

    public function getPaymentNotification()
    {
        return $this->notification;
    }

    public function validatePayment()
    {
        $code = $this->getReturnCode();
        if ($code === 0 or $code === 1) {
            // 0 - Order successfully confirmed.
            // 1 - Order already confirmed.
            return true;
        } elseif ($code === 2) {
            throw new \Exception('Incorrect parameters values');
        } elseif ($code === 3) {
            throw new \Exception('Order not found');
        } elseif ($code === 4) {
            throw new \Exception('Postback is missing data');
        } elseif ($code === 5) {
            throw new \Exception('Order not paid yet');
        } elseif ($code === 6) {
            throw new \Exception('Error reported by the Virtual Store');
        } elseif ($code === 7) {
            throw new \Exception('Value for "hash_key" parameter is incorrect');
        } elseif ($code === 9) {
            throw new \Exception('Wrong postback url. Please check the "Test Environment" section');
        }
        throw new \Exception('Unknown return code "'.$code.'"');
    }

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

    protected function getURL()
    {
        if ($this->notification->getPayment()->getTestMode()) {
            return static::POSTBACK_TEST_URL;
        }

        return static::POSTBACK_URL;
    }

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

    protected function getReturnCode()
    {
        list($response, $infos) = $this->curlRequest();

        if (mb_strlen($response) === 0) {
            throw new \Exception('Empty response (HTTP response code : '.$infos['http_code'].')');
        }

        if (strpos($response, 'CODRET=') === false or mb_strlen($response) < 8) {
            throw new \Exception('No return code provided (HTTP response code : '.$infos['http_code'].')');
        }

        return (int) str_replace('CODRET=', '', trim($response));
    }
}
