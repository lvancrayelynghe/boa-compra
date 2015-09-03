<?php

namespace Benoth\BoaCompra;

/**
 * Process the notification received from BoaCompra, informing that the payment has cleared.
 *
 * Based on documentation v2.48
 */
class PaymentNotification
{
    /* Payment object */
    protected $payment;

    /* Order Identification on UOL BoaCompra */
    protected $transactionId;

    /* Order currency ISO code */
    protected $currencyCode;

    /* Identification of the payment method used by the final user */
    protected $paymentId;

    /* List of BoaCompra IPs */
    protected $authorizedIps = array(
        '200.147.106.24',
        '200.147.106.25',
        '200.147.106.65',
        '200.147.106.66',
    );

    /**
     * Create a new BoaCompra notification checker
     * All parameters (except $payment) must the datas received by distant server
     * (generally from $_POST except for $ipAddress which generallyis taken in $_SERVER).
     *
     * @param Payment $payment
     * @param string  $storeId
     * @param string  $transactionId
     * @param string  $orderId
     * @param string  $amount
     * @param string  $currencyCode
     * @param string  $paymentId
     * @param string  $ipAddress
     */
    public function __construct(Payment $payment, $storeId, $transactionId, $orderId, $amount, $currencyCode, $paymentId, $ipAddress = null)
    {
        $this->payment = $payment;

        $this->validateReturnedDatas($storeId, $orderId, $amount, $currencyCode, $paymentId);

        if (!is_null($ipAddress)) {
            $this->validateIpAddress($ipAddress);
        }

        $this->transactionId = $transactionId;
        $this->currencyCode  = $currencyCode;
        $this->paymentId     = $paymentId;
    }

    /**
     * Get the payment object.
     *
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Get the Transaction Id sent by BoaCompra.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Get the Currency Code sent by BoaCompra.
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Get the Payment Id (End User payment method) sent by BoaCompra.
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Validate the datas sent by BoaCompra.
     *
     * @param string $storeId
     * @param string $orderId
     * @param string $amount
     * @param string $currencyCode
     * @param string $paymentId
     *
     * @throws Exception If the provided $storeId is different from the one defined in VirtualStoreIdentification
     * @throws Exception If the provided $orderId is different from the one defined in Payment
     * @throws Exception If the provided $amount is different from the one defined in Payment
     * @throws Exception If the provided $currencyCode is different from the one defined in Payment (if initially chosen)
     * @throws Exception If the provided $paymentId is different from the one defined in Payment (if initially chosen)
     *
     * @return  void
     */
    protected function validateReturnedDatas($storeId, $orderId, $amount, $currencyCode, $paymentId)
    {
        if ($storeId != $this->payment->getVirtualStoreIdentification()->getStoreId()) {
            throw new \Exception('Store ID received differs from defined Store ID ('.$storeId.' != '.$this->payment->getVirtualStoreIdentification()->getStoreId().')');
        }

        if ($orderId != $this->payment->getOrderId()) {
            throw new \Exception('Order ID received differs from defined Order ID ('.$orderId.' != '.$this->payment->getOrderId().')');
        }

        if ($amount != $this->payment->getAmount()) {
            throw new \Exception('Amount received differs from defined Amount ('.$amount.' != '.$this->payment->getAmount().')');
        }

        $definedCurrencyCode = $this->payment->getCurrencyCode();
        if (!is_null($definedCurrencyCode) && $currencyCode != $definedCurrencyCode) {
            throw new \Exception('Currency Code received differs from defined Currency Code ('.$currencyCode.' != '.$definedCurrencyCode.')');
        }

        $definedPaymentID = $this->payment->getPaymentId();
        if (!is_null($definedPaymentID) && $paymentId != $definedPaymentID) {
            throw new \Exception('Payment ID received differs from defined Payment ID ('.$paymentId.' != '.$definedPaymentID.')');
        }
    }

    /**
     * Check if the IP Address is one from BoaCompra servers.
     *
     * @param string $ipAddress
     *
     * @throws Exception If the provided $ipAddress is unauthorized
     *
     * @return bool
     */
    protected function validateIpAddress($ipAddress)
    {
        if (!in_array($ipAddress, $this->authorizedIps)) {
            throw new \Exception('Unauthorized IP Adress ('.$ipAddress.')');
        }

        return true;
    }
}
