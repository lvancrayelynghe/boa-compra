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

    /**
     * Create a new Virtual Store Identification
     *
     * @param string $storeId Virtual Store ID
     * @param string $key     Virtual Store Secret Key
     *
     * @throws Exception If the provided Store ID doesn't contain only numbers or more than 6 characters
     */
    public function __construct($storeId, $key)
    {
        if (!ctype_digit($storeId) || mb_strlen((string) $storeId) > 6) {
            throw new \Exception('Store ID must be an integer with max length of 6');
        }

        $this->storeId = $storeId;
        $this->key     = $key;
    }

    /**
     * Get the Store ID
     *
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Get the Store Secret Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
