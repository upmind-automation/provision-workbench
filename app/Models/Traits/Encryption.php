<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Contracts\Encryption\DecryptException;

/**
 * Recursively encrypts and decrypts data.
 */
trait Encryption
{
    /**
     * Recursively encrypts the given data.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function encrypt($data)
    {
        if (is_iterable($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->encrypt($value);
            }

            return $data;
        }

        if (!is_string($data) || is_numeric($data) || empty($data)) {
            return $data;
        }

        return encrypt($data);
    }

    /**
     * Recursively decrypts the given data.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function decrypt($data)
    {
        if (is_iterable($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->decrypt($value);
            }

            return $data;
        }

        if (!is_string($data) || is_numeric($data) || empty($data)) {
            return $data;
        }

        try {
            return decrypt($data);
        } catch (DecryptException $e) {
            // If the payload cannot be decrypted, assume it was already plaintext.
            return $data;
        }
    }
}
