<?php

use Benoth\BoaCompra\EndUser;
use Benoth\BoaCompra\Payment;
use Benoth\BoaCompra\PaymentCheckStatus;
use Benoth\BoaCompra\PaymentNotification;
use Benoth\BoaCompra\VirtualStoreIdentification;

class PaymentCheckStatusTest extends PHPUnit_Framework_TestCase
{
    protected $checkstatus;
    protected $stub;

    public function setUp()
    {
        $vsi          = new VirtualStoreIdentification('12', 'qwerty');
        $endUser      = new EndUser('me@example.com');
        $payment      = new Payment($vsi, $endUser, 'http://localhost.dev/test.php', 'http://localhost.dev/notify.php', 'EUR', '42', 'This is a test order', 1200);
        $notification = new PaymentNotification($payment, '12', 'QWERTY-0123456', '42', '1200', 'EUR', '1');

        $this->checkstatus = new PaymentCheckStatus($notification);

        $this->stub = $this->getMockBuilder('Benoth\BoaCompra\PaymentCheckStatus')
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
          'cmd'              => '_code-check',
          'hash_key'         => '1c5311317b3aa6eb739bd2ebefa315d8',
        );
    }

    public function testSimple()
    {
        $this->assertInstanceOf('Benoth\BoaCompra\PaymentCheckStatus', $this->checkstatus);
        $this->assertInstanceOf('Benoth\BoaCompra\PaymentNotification', $this->checkstatus->getPaymentNotification());
    }

    public function testGetPostFields()
    {
        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($this->checkstatus));
        $method     = $reflection->getMethod('getPostFields');
        $method->setAccessible(true);

        $this->assertSame($this->postfields, $method->invokeArgs($this->checkstatus, array()));
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
             ->will($this->returnValue(array('{"ERR": ""}', array('http_code' => 500))));

        $this->stub->validatePayment();
    }

    public function testWrongResponseCodeException()
    {
        $this->setExpectedException('Exception', 'Invalid response format (not JSON ?) (HTTP response code : 500)');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": ""}', array('http_code' => 500))));

        $this->stub->validatePayment();
    }

    public function testResponseCode0()
    {
        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 0}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode1()
    {
        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 1}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode2Exception()
    {
        $this->setExpectedException('Exception', 'Incorrect parameters values');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 2}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode3Exception()
    {
        $this->setExpectedException('Exception', 'Order not found');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 3}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode4Exception()
    {
        $this->setExpectedException('Exception', 'Postback are missing data');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 4}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode5Exception()
    {
        $this->setExpectedException('Exception', 'Order not paid yet');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 5}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode6Exception()
    {
        $this->setExpectedException('Exception', 'Error reported by the Virtual Store');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 6}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode7Exception()
    {
        $this->setExpectedException('Exception', 'Value for "hash_key" parameter is incorrect');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 7}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode8Exception()
    {
        $this->setExpectedException('Exception', 'Order paid but not delivered');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 8}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCode9Exception()
    {
        $this->setExpectedException('Exception', 'Wrong postback url. Please check the "Test Environment" section');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 9}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }

    public function testResponseCodeUnkownException()
    {
        $this->setExpectedException('Exception', 'Unknown return code "999"');

        $this->stub->expects($this->any())
             ->method('curlRequest')
             ->will($this->returnValue(array('{"CODRET": 999}', array('http_code' => 200))));

        $this->assertSame(true, $this->stub->validatePayment());
    }
}
