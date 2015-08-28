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
        $this->assertSame(false, $this->validator->nonEmptyString(''));
        $this->assertSame(false, $this->validator->nonEmptyString('qwerty', 2));
        $this->assertSame(true, $this->validator->nonEmptyString(1));
        $this->assertSame(true, $this->validator->nonEmptyString(1.2));
        $this->assertSame(true, $this->validator->nonEmptyString('qwerty'));
    }

    public function testNonEmptyInt()
    {
        $this->assertSame(false, $this->validator->nonEmptyInt(''));
        $this->assertSame(false, $this->validator->nonEmptyInt(1));
        $this->assertSame(false, $this->validator->nonEmptyInt('qwerty', 2));
        $this->assertSame(false, $this->validator->nonEmptyInt('123', 2));
        $this->assertSame(true, $this->validator->nonEmptyInt('1'));
        $this->assertSame(true, $this->validator->nonEmptyInt('12'));
    }

    public function testNonEmptyEmail()
    {
        $this->assertSame(false, $this->validator->nonEmptyEmail(''));
        $this->assertSame(false, $this->validator->nonEmptyEmail(1));
        $this->assertSame(false, $this->validator->nonEmptyEmail('qwerty', 2));
        $this->assertSame(false, $this->validator->nonEmptyEmail('qwerty'));
        $this->assertSame(false, $this->validator->nonEmptyEmail('test@example.com', 5));
        $this->assertSame(true, $this->validator->nonEmptyEmail('test@example.com'));
    }

    public function testNonEmptyUrl()
    {
        $this->assertSame(false, $this->validator->nonEmptyUrl(''));
        $this->assertSame(false, $this->validator->nonEmptyUrl(1));
        $this->assertSame(false, $this->validator->nonEmptyUrl('qwerty', 2));
        $this->assertSame(false, $this->validator->nonEmptyUrl('http://localhost.dev/', 5));
        $this->assertSame(true, $this->validator->nonEmptyUrl('http://localhost.dev/'));
    }
}
