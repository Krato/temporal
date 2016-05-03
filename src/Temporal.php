<?php

namespace EricLagarda\Temporal;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class Temporal{

    protected $key;

    public function __construct(){
        $this->key = $this->max16(config('app.key'));
    }

    /**
     * Create temporal url token
     *
     * @param $id
     * @param $expires
     * @return string
     */
	public function create($id, $expires){
        $payload = ['id'=> $id,'expires' => $expires, 'created_at' => Carbon::now()->toDateTimeString()];
        $payload = urldecode(http_build_query($payload));
        return $this->encrypt($payload);
    }

    /**
     * Check if temporal url is valid or not
     *
     * @param $data
     * @return bool|string
     */
    public function check($data){
        $code = $this->decrypt($data);
        $createdAt = Carbon::parse($code->created_at);
        if(Carbon::now()->subMinutes($code->expires)->gt($createdAt)) {
            return false;
        }
        return $code;
    }

    /**
     * Encrypts data
     *
     * @param $data
     * @return string
     */
    private function encrypt($data){
        return strtr(strtr(trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $data, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))), '+', '_'), '/', '-');
    }

    /**
     * Decrypt an string based on
     *
     * @param $data
     * @return string
     */
    private function decrypt($data){
        $data = strtr(strtr($data, '_', '+'), '-', '/');
        $code = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($data), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
        parse_str($code, $object);
        return (object)$object;
    }

    private function max16($salt){
        return substr($salt, 0, 16);
    }
}