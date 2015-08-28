<?php

use Benoth\BoaCompra\EndUser;
use Benoth\BoaCompra\Payment;
use Benoth\BoaCompra\PaymentNotification;
use Benoth\BoaCompra\PaymentPostBack;
use Benoth\BoaCompra\VirtualStoreIdentification;

class PaymentPostBackTest extends PHPUnit_Framework_TestCase
{
    protected $postback;
    protected $stub;

    public function setUp()
    {
        $vsi          = new VirtualStoreIdentification('12', 'qwerty');
        $endUser      = new EndUser('me@example.com');
        $payment      = new Payment($vsi, $endUser, 'http://localhost.dev/test.php', 'http://localhost.dev/notify.php', 'EUR', '42', 'This is a test order', 1200);
        $notification = new PaymentNotification($payment, '12', 'QWERTY-0123456', '42', '1200', 'EUR', '1');

        $this->postback = new PaymentPostBack($notification);

        $this->stub = $this->getMockBuilder('Benoth\BoaCompra\PaymentPostBack')
                     ->setMethods(array('curlRequest'))
                     ->setConstructorArgs(array($notification))
                     ->getMock();

        $this->postfields = array(
          'store_id'         => '12',
          'transaction_id'   => 'QWERTY-0123456',
          'order_id'         => '42',
          'amount'           => 1200,
          'currency_code'    => 'EUR',
          'payment_id'       => '1',
          'country_payment'  => null,
          'customer_country' => null,
          'cmd'              => '_code-notify',
          'hash_key'         => '1c5311317b3aa6eb739bd2ebefa315d8',
        );
    }

    public function testSimple()
    {
        $this->assertInstanceOf('Benoth\BoaCompra\PaymentPostBack', $this->postback);
        $this->assertInstanceOf('Benoth\BoaCompra\PaymentNotification', $this->postback->getPaymentNotification());
    }

    public function testGetPostFields()
    {
        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($this->postback));
        $method     = $reflection->getMethod('getPostFields');
        $method->setAccessible(true);

        $this->assertSame($this->postfields, $method->invokeArgs($this->postback, array()));
    }

    public function testGetUrlProd()
    {
        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($this->postback));
        $method     = $reflection->getMethod('getURL');
        $method->setAccessible(true);

        $this->assertSame(PaymentPostBack::POSTBACK_URL, $method->invokeArgs($this->postback, array()));
    }

    public function testGetUrlTest()
    {
        $this->postback->getPaymentNotification()->getPayment()->setTestMode(1);

        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($this->postback));
        $method     = $reflection->getMethod('getURL');
        $method->setAccessible(true);

        $this->assertSame(PaymentPostBack::POSTBACK_TEST_URL, $method->invokeArgs($this->postback, array()));
    }

    public function testResponseCodeEmptyException()
    {
        $this->setExpectedException('Exception', 'Empty response (HTTP response code : 500)');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('', array('http_code' => 500))));

        $this->stub->validatePayment();
    }

    public function testNoResponseCodeException()
    {
        $this->setExpectedException('Exception', 'No return code provided (HTTP response code : 500)');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=', array('http_code' => 500))));

        $this->stub->validatePayment();
    }

    public function testResponseCode0()
    {
        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=0', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode1()
    {
        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=1', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode2Exception()
    {
        $this->setExpectedException('Exception', 'Incorrect parameters values');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=2', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode3Exception()
    {
        $this->setExpectedException('Exception', 'Order not found');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=3', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode4Exception()
    {
        $this->setExpectedException('Exception', 'Postback is missing data');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=4', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode5Exception()
    {
        $this->setExpectedException('Exception', 'Order not paid yet');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=5', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode6Exception()
    {
        $this->setExpectedException('Exception', 'Error reported by the Virtual Store');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=6', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode7Exception()
    {
        $this->setExpectedException('Exception', 'Value for "hash_key" parameter is incorrect');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=7', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode9Exception()
    {
        $this->setExpectedException('Exception', 'Wrong postback url. Please check the "Test Environment" section');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=9', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCodeUnkownException()
    {
        $this->setExpectedException('Exception', 'Unknown return code "999"');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('CODRET=999', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }
}
