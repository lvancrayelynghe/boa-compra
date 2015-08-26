<?php

use Benoth\BoaCompra\DataValidator;

class DataValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new DataValidator();
    }

    public function testNonEmptyString()
    {
        $this->assertEquals(false, $this->validator->nonEmptyString(''));
        $this->assertEquals(false, $this->validator->nonEmptyString(1));
        $this->assertEquals(false, $this->validator->nonEmptyString('qwerty', 2));
        $this->assertEquals(true, $this->validator->nonEmptyString('qwerty'));
    }

    public function testNonEmptyInt()
    {
        $this->assertEquals(false, $this->validator->nonEmptyInt(''));
        $this->assertEquals(false, $this->validator->nonEmptyInt(1));
        $this->assertEquals(false, $this->validator->nonEmptyInt('qwerty', 2));
        $this->assertEquals(false, $this->validator->nonEmptyInt('123', 2));
        $this->assertEquals(true, $this->validator->nonEmptyInt('1'));
        $this->assertEquals(true, $this->validator->nonEmptyInt('12'));
    }

    public function testNonEmptyEmail()
    {
        $this->assertEquals(false, $this->validator->nonEmptyEmail(''));
        $this->assertEquals(false, $this->validator->nonEmptyEmail(1));
        $this->assertEquals(false, $this->validator->nonEmptyEmail('qwerty', 2));
        $this->assertEquals(false, $this->validator->nonEmptyEmail('qwerty'));
        $this->assertEquals(false, $this->validator->nonEmptyEmail('test@example.com', 5));
        $this->assertEquals(true, $this->validator->nonEmptyEmail('test@example.com'));
    }

    public function testNonEmptyUrl()
    {
        $this->assertEquals(false, $this->validator->nonEmptyUrl(''));
        $this->assertEquals(false, $this->validator->nonEmptyUrl(1));
        $this->assertEquals(false, $this->validator->nonEmptyUrl('qwerty', 2));
        $this->assertEquals(false, $this->validator->nonEmptyUrl('http://localhost.dev/', 5));
        $this->assertEquals(true, $this->validator->nonEmptyUrl('http://localhost.dev/'));
    }
}
