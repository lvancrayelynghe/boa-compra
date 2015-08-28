<?php

use Benoth\BoaCompra\EndUser;
use Benoth\BoaCompra\Payment;
use Benoth\BoaCompra\VirtualStoreIdentification;

class PaymentTest extends PHPUnit_Framework_TestCase
{
    protected $vsi;

    protected $endUser;

    protected $others;

    protected $basicPayment;

    protected $longString = 'qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789qwerty0123456789';

    public function setUp()
    {
        $this->vsi = new VirtualStoreIdentification('12', 'qwerty');

        $this->endUser = new EndUser('me@example.com');

        $this->others                    = new stdClass();
        $this->others->return            = 'http://localhost.dev/test.php';
        $this->others->notify_url        = 'http://localhost.dev/notify.php';
        $this->others->currency_code     = 'EUR';
        $this->others->order_id          = '42';
        $this->others->order_description = 'This is a test order';
        $this->others->amount            = 1200;

        $this->basicPayment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->others->order_description, $this->others->amount);
    }

    public function testGetters()
    {
        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->others->order_description, $this->others->amount);

        $this->assertSame($this->vsi,           $this->basicPayment->getVirtualStoreIdentification());
        $this->assertSame($this->endUser,       $this->basicPayment->getEndUser());
        $this->assertSame(Payment::BILLING_URL, $this->basicPayment->getBillingURL());
        $this->assertSame(null,                 $this->basicPayment->getCountryIso());
        $this->assertSame(null,                 $this->basicPayment->getProjectId());
        $this->assertSame(null,                 $this->basicPayment->getPaymentId());
        $this->assertSame(null,                 $this->basicPayment->getPaymentGroup());
        $this->assertSame(null,                 $this->basicPayment->getToken());
        $this->assertSame(null,                 $this->basicPayment->getTestMode());
    }

    public function testSetters()
    {
        $country_iso   = 'US';
        $project_id    = 3;
        $payment_id    = '2';
        $payment_group = 1;
        $token         = '123';
        $test_mode     = 1;

        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setCountryIso($country_iso));
        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setProjectId($project_id));
        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setPaymentId($payment_id));
        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setPaymentGroup($payment_group));
        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setToken($token));
        $this->assertInstanceOf('Benoth\BoaCompra\Payment', $this->basicPayment->setTestMode($test_mode));

        $this->assertSame($country_iso,   $this->basicPayment->getCountryIso());
        $this->assertSame($project_id,    $this->basicPayment->getProjectId());
        $this->assertSame($payment_id,    $this->basicPayment->getPaymentId());
        $this->assertSame($payment_group, $this->basicPayment->getPaymentGroup());
        $this->assertSame($token,         $this->basicPayment->getToken());
        $this->assertSame($test_mode,     $this->basicPayment->getTestMode());
    }

    public function testCountryIsoException()
    {
        $this->setExpectedException('Exception', 'Invalid countryIso. Must be nonEmptyString (max length of 2)');

        $this->basicPayment->setCountryIso($this->longString);
    }

    public function testProjectIdException()
    {
        $this->setExpectedException('Exception', 'Invalid projectId. Must be nonEmptyString (max length of 6)');

        $this->basicPayment->setProjectId($this->longString);
    }

    public function testPaymentIdException()
    {
        $this->setExpectedException('Exception', 'Invalid paymentId. Must be nonEmptyString (max length of 6)');

        $this->basicPayment->setPaymentId($this->longString);
    }

    public function testPaymentGroupException()
    {
        $this->setExpectedException('Exception', 'Invalid paymentGroup. Must be nonEmptyString (max length of 20)');

        $this->basicPayment->setPaymentGroup($this->longString);
    }

    public function testTokenException()
    {
        $this->setExpectedException('Exception', 'Invalid token. Must be nonEmptyString (max length of 32)');

        $this->basicPayment->setToken($this->longString);
    }

    public function testTestModeException()
    {
        $this->setExpectedException('Exception', 'Invalid testMode. Must be validStringBool');

        $this->basicPayment->setTestMode('3');
    }

    public function testReturnUrlException()
    {
        $this->setExpectedException('Exception', 'Invalid returnUrl. Must be nonEmptyUrl (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, 'ftp://user:pass@localhost.dev/test', $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->others->order_description, $this->others->amount);
    }

    public function testNotifyUrlFormatException()
    {
        $this->setExpectedException('Exception', 'Invalid notifyUrl. Must be validUrl (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, 'ftp://user:pass@localhost.dev/test', $this->others->currency_code, $this->others->order_id, $this->others->order_description, $this->others->amount);
    }

    public function testNotifyUrlPortException()
    {
        $this->setExpectedException('Exception', 'Invalid notifyUrl. Must be validUrl (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, 'http://localhost.dev:8080/test', $this->others->currency_code, $this->others->order_id, $this->others->order_description, $this->others->amount);
    }

    public function testCurrencyCodeException()
    {
        $this->setExpectedException('Exception', 'Invalid currencyCode. Must be validCurrencyCode (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, 'CAD', $this->others->order_id, $this->others->order_description, $this->others->amount);
    }

    public function testOrderIdEmptyException()
    {
        $this->setExpectedException('Exception', 'Invalid orderId. Must be nonEmptyString (max length of 30)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, '', $this->others->order_description, $this->others->amount);
    }

    public function testOrderIdLengthException()
    {
        $this->setExpectedException('Exception', 'Invalid orderId. Must be nonEmptyString (max length of 30)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->longString, $this->others->order_description, $this->others->amount);
    }

    public function testOrderDescriptionEmptyException()
    {
        $this->setExpectedException('Exception', 'Invalid orderDescription. Must be nonEmptyString (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, '', $this->others->amount);
    }

    public function testOrderDescriptionLengthException()
    {
        $this->setExpectedException('Exception', 'Invalid orderDescription. Must be nonEmptyString (max length of 200)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->longString, $this->others->amount);
    }

    public function testAmountEmptyExceptionFormat()
    {
        $this->setExpectedException('Exception', 'Invalid amount. Must be nonEmptyInt (max length of 7)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->others->order_description, '');
    }

    public function testAmountFormatExceptionFormat()
    {
        $this->setExpectedException('Exception', 'Invalid amount. Must be nonEmptyInt (max length of 7)');

        $payment = new Payment($this->vsi, $this->endUser, $this->others->return, $this->others->notify_url, $this->others->currency_code, $this->others->order_id, $this->others->order_description, 'azerty');
    }
}
