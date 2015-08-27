<?php namespace Benoth\BoaCompra;

/**
 * Send the postback to BoaCompra to confirm the order information
 *
 * Based on documentation v2.48
 */
class PaymentCheckStatus extends PaymentPostBack
{
    /* List of BoaCompra error codes and equivalent message */
    protected $errorCodes = array(
        2 => 'Incorrect parameters values',
        3 => 'Order not found',
        4 => 'Postback are missing data',
        5 => 'Order not paid yet',
        6 => 'Error reported by the Virtual Store',
        7 => 'Value for "hash_key" parameter is incorrect',
        8 => 'Order paid but not delivered',
        9 => 'Wrong postback url. Please check the "Test Environment" section',
    );

    protected function getPostFields()
    {
        $fields = array(
            'store_id'         => $this->notification->getPayment()->getVirtualStoreIdentification()->getStoreId(),
            'transaction_id'   => $this->notification->getTransactionId(),
            'order_id'         => $this->notification->getPayment()->getOrderId(),
            'amount'           => $this->notification->getPayment()->getAmount(),
            'currency_code'    => $this->notification->getCurrencyCode(),
            'payment_id'       => $this->notification->getPaymentId(),
            'cmd'              => '_code-check',
            'hash_key'         => $this->generateHashKey(),
        );

        return $fields;
    }

    protected function getReturnCode()
    {
        list($response, $infos) = $this->getResponse();

        $response = json_decode($response);
        if (!is_object($response) || !property_exists($response, 'CODRET') || mb_strlen((string) $response->CODRET) < 1) {
            throw new \Exception('Invalid response format (not JSON ?) (HTTP response code : '.$infos['http_code'].')');
        }

        return (int) $response->CODRET;
    }
}
