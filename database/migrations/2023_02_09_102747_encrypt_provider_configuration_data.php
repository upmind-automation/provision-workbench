<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EncryptProviderConfigurationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('provider_configurations')->get() as $providerConfiguration) {
            DB::table('provider_configurations')
                ->where('id', $providerConfiguration->id)
                ->update([
                    'data' => json_encode($this->encrypt(json_decode($providerConfiguration->data, true))),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (DB::table('provider_configurations')->get() as $providerConfiguration) {
            DB::table('provider_configurations')
                ->where('id', $providerConfiguration->id)
                ->update([
                    'data' => json_encode($this->decrypt(json_decode($providerConfiguration->data, true))),
                ]);
        }
    }

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
