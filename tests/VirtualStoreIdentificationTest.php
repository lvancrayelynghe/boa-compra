<?php

use Benoth\BoaCompra\VirtualStoreIdentification;

class VirtualStoreIdentificationTest extends PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $store_id = '1';
        $key      = 'azerty';
        $vsi      = new VirtualStoreIdentification($store_id, $key);

        $this->assertSame($store_id, $vsi->getStoreId());
        $this->assertSame($key, $vsi->getKey());
    }

    public function testStoreIdExceptionNumeric()
    {
        $this->setExpectedException('Exception', 'Store ID must be an integer with max length of 6');

        $vsi = new VirtualStoreIdentification('azerty', 'azerty');
    }

    public function testStoreIdExceptionLength()
    {
        $this->setExpectedException('Exception', 'Store ID must be an integer with max length of 6');

        $vsi = new VirtualStoreIdentification('azertyuiop', 'azerty');
    }
}
