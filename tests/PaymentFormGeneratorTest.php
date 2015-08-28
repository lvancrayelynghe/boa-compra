<?php

use Benoth\BoaCompra\EndUser;
use Benoth\BoaCompra\Payment;
use Benoth\BoaCompra\PaymentFormGenerator;
use Benoth\BoaCompra\VirtualStoreIdentification;

class PaymentFormGeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $payment;

    protected $forms;

    public function setUp()
    {
        $vsi = new VirtualStoreIdentification('12', 'qwerty');

        $endUser = new EndUser('me@example.com');

        $others                    = new stdClass();
        $others->return            = 'http://localhost.dev/test.php';
        $others->notify_url        = 'http://localhost.dev/notify.php';
        $others->currency_code     = 'EUR';
        $others->order_id          = '42';
        $others->order_description = 'This is a test order';
        $others->amount            = 1200;

        $this->payment = new Payment($vsi, $endUser, $others->return, $others->notify_url, $others->currency_code, $others->order_id, $others->order_description, $others->amount);

        $this->forms['simple'] =
'<form method="POST" name="boacompra-billing" action="https://billing.boacompra.com/payment.php">
'."\t".'<input type="hidden" name="store_id" value="12">
'."\t".'<input type="hidden" name="return" value="http://localhost.dev/test.php">
'."\t".'<input type="hidden" name="notify_url" value="http://localhost.dev/notify.php">
'."\t".'<input type="hidden" name="currency_code" value="EUR">
'."\t".'<input type="hidden" name="order_id" value="42">
'."\t".'<input type="hidden" name="order_description" value="This is a test order">
'."\t".'<input type="hidden" name="amount" value="1200">
'."\t".'<input type="hidden" name="client_email" value="me@example.com">
'."\t".'<input type="hidden" name="hash_key" value="d5e084576452ba6d96816a914079c5bb">
</form>
';
        $this->forms['with_names'] =
'<form method="POST" name="boacompra-billing" action="https://billing.boacompra.com/payment.php">
'."\t".'<input type="hidden" name="store_id" value="12">
'."\t".'<input type="hidden" name="return" value="http://localhost.dev/test.php">
'."\t".'<input type="hidden" name="notify_url" value="http://localhost.dev/notify.php">
'."\t".'<input type="hidden" name="currency_code" value="EUR">
'."\t".'<input type="hidden" name="order_id" value="42">
'."\t".'<input type="hidden" name="order_description" value="This is a test order">
'."\t".'<input type="hidden" name="amount" value="1200">
'."\t".'<input type="hidden" name="client_email" value="me@example.com">
'."\t".'<input type="hidden" name="hash_key" value="d5e084576452ba6d96816a914079c5bb">
'."\t".'<input type="hidden" name="client_name" value="John Doe">
'."\t".'<input type="hidden" name="client_city" value="New York">
</form>
';
        $this->forms['with_project'] =
'<form method="POST" name="boacompra-billing" action="https://billing.boacompra.com/payment.php">
'."\t".'<input type="hidden" name="store_id" value="12">
'."\t".'<input type="hidden" name="return" value="http://localhost.dev/test.php">
'."\t".'<input type="hidden" name="notify_url" value="http://localhost.dev/notify.php">
'."\t".'<input type="hidden" name="currency_code" value="EUR">
'."\t".'<input type="hidden" name="order_id" value="42">
'."\t".'<input type="hidden" name="order_description" value="This is a test order">
'."\t".'<input type="hidden" name="amount" value="1200">
'."\t".'<input type="hidden" name="client_email" value="me@example.com">
'."\t".'<input type="hidden" name="hash_key" value="d5e084576452ba6d96816a914079c5bb">
'."\t".'<input type="hidden" name="token" value="qwerty">
'."\t".'<input type="hidden" name="client_name" value="John Doe">
</form>
';
    }

    public function testSimple()
    {
        $form = new PaymentFormGenerator($this->payment);

        $this->assertSame($this->forms['simple'], $form->render());
    }

    public function testWithNames()
    {
        $this->payment->getEndUser()->setName('John Doe');
        $this->payment->getEndUser()->setCity('New York');

        $form = new PaymentFormGenerator($this->payment);

        $this->assertSame($this->forms['with_names'], $form->render());
    }

    public function tesTokenAndName()
    {
        $this->payment->getEndUser()->setName('John Doe');
        $this->payment->setToken('qwerty');

        $form = new PaymentFormGenerator($this->payment);

        $this->assertSame($this->forms['with_project'], $form->render());
    }

    public function testCallMethodMissingColonException()
    {
        $this->setExpectedException('Exception', 'Invalid method "test"');

        $form = new PaymentFormGenerator($this->payment);

        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($form));
        $method     = $reflection->getMethod('callMethod');
        $method->setAccessible(true);
        $method->invokeArgs($form, array('test'));
    }

    public function testCallMethodInvalidMethodException()
    {
        $this->setExpectedException('Exception', 'Invalid method "test:test"');

        $form = new PaymentFormGenerator($this->payment);

        // Use reflection to make the method accessible
        $reflection = new \ReflectionClass(get_class($form));
        $method     = $reflection->getMethod('callMethod');
        $method->setAccessible(true);
        $method->invokeArgs($form, array('test:test'));
    }
}
