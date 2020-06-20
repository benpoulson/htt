<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EncryptableModel
 * Encrypts fields upon writes, and decrypts on reads.
 * Adds an additional layer of security in case a database goes walkabouts...
 * @package App
 */
abstract class EncryptableModel extends Model
{

    /**
     * Returns a list of encryptable fields
     * @return array<string>
     */
    abstract public function getEncryptedFields(): array;

    /**
     * If the attribute is in the encryptable array then decrypt it.
     * @param string $key
     * @return mixed $value
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->getEncryptedFields()) && $value !== '') {
            $value = decrypt($value);
        }
        return $value;
    }

    /**
     * If the attribute is in the encryptable array then encrypt it.
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncryptedFields())) {
            $value = encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * When need to make sure that we iterate through all the keys.
     * @return array<string, string>
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->getEncryptedFields() as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }
}
