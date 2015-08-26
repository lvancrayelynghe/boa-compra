<?php namespace Benoth\BoaCompra;

/**
 * BoaCompra Virtual Store Identification
 *
 * Based on documentation v2.48
 */
class VirtualStoreIdentification
{
    /* Virtual Store Identification on BoaCompra (max length 6) */
    protected $storeId;

    /* Virtual Store Identification on BoaCompra */
    protected $key;

    public function __construct($storeId, $key)
    {
        if (!ctype_digit($storeId) or mb_strlen((string) $storeId) > 6) {
            throw new \Exception('Store ID must be an integer with max length of 6');
        }

        $this->storeId = $storeId;
        $this->key     = $key;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function getKey()
    {
        return $this->key;
    }
}
