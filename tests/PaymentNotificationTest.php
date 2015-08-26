<?php

use Benoth\BoaCompra\VirtualStoreIdentification;
use Benoth\BoaCompra\EndUser;
use Benoth\BoaCompra\Payment;
use Benoth\BoaCompra\PaymentNotification;

class PaymentNotificationTest extends PHPUnit_Framework_TestCase
{
    protected $payment;

    protected $others;

    public function setUp()
    {
        $vsi = new VirtualStoreIdentification('12', 'qwerty');

        $endUser = new EndUser('me@example.com');

        $this->others = new stdClass();
        $this->others->store_id       = '12';
        $this->others->transaction_id = 'QWERTY-0123456';
        $this->others->order_id       = '42';
        $this->others->amount         = '1200';
        $this->others->currency_code  = 'EUR';
        $this->others->payment_id     = '1';
        $this->others->ip_adress      = '200.147.106.65';

        $this->payment = new Payment($vsi, $endUser, 'http://localhost.dev/test.php', 'http://localhost.dev/notify.php', 'EUR', '42', 'This is a test order', 1200);
        $this->payment->setPaymentId($this->others->payment_id);
    }

    public function testGetters()
    {
        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id);

        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $notification->getPayment());
        $this->assertEquals($this->payment, $notification->getPayment());

        $this->assertEquals($this->others->transaction_id, $notification->getTransactionId());
        $this->assertEquals($this->others->currency_code,  $notification->getCurrencyCode());
        $this->assertEquals($this->others->payment_id,     $notification->getPaymentId());
    }

    public function testSimple()
    {
        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id);

        $this->assertInstanceOf('Benoth\BoaCompra\PaymentNotification', $notification);
    }

    public function testValidIp()
    {
        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id, $this->others->ip_adress);

        $this->assertInstanceOf('Benoth\BoaCompra\PaymentNotification', $notification);
    }

    public function testStoreIdException()
    {
        $store_id = 1;

        $this->setExpectedException('Exception', 'Store ID received differs from defined Store ID ('.$store_id.' != '.$this->others->store_id.')');

        $notification = new PaymentNotification($this->payment, $store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id);
    }

    public function testOrderIdException()
    {
        $order_id = 'ABC';

        $this->setExpectedException('Exception', 'Order ID received differs from defined Order ID ('.$order_id.' != '.$this->others->order_id.')');

        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id);
    }

    public function testAmountException()
    {
        $amount = 4000;

        $this->setExpectedException('Exception', 'Amount received differs from defined Amount ('.$amount.' != '.$this->others->amount.')');

        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $amount, $this->others->currency_code, $this->others->payment_id);
    }

    public function testCurrencyCodeException()
    {
        $currency_code = 'NIO';

        $this->setExpectedException('Exception', 'Currency Code received differs from defined Currency Code ('.$currency_code.' != '.$this->others->currency_code.')');

        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $currency_code, $this->others->payment_id);
    }

    public function testPaymentIdException()
    {
        $payment_id = '987';

        $this->setExpectedException('Exception', 'Payment ID received differs from defined Payment ID ('.$payment_id.' != '.$this->others->payment_id.')');

        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $payment_id);
    }

    public function testInvalidIpException()
    {
        $this->setExpectedException('Exception', 'Unauthorized IP Adress (127.0.0.1)');

        $notification = new PaymentNotification($this->payment, $this->others->store_id, $this->others->transaction_id, $this->others->order_id, $this->others->amount, $this->others->currency_code, $this->others->payment_id, '127.0.0.1');
    }
}
