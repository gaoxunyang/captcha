<?php
namespace Base;
class Encryption
{
    public static function encode($data)
    {
        $handler = self::getMcryptHandler();
        $encrypted = self::urlSafeBase64Encode(mcrypt_generic($handler, $data));
        mcrypt_generic_deinit($handler);

        return $encrypted;
    }

    public static function decode($data)
    {
        $handler = self::getMcryptHandler();
        $decrypted = mdecrypt_generic($handler, self::urlSafeBase64Decode($data));
        mcrypt_generic_deinit($handler);

        return $decrypted;
    }

    private static function getMcryptHandler()
    {
        $td = mcrypt_module_open('rijndael-256', '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr(md5('this is secret key'), 0, $ks);
        mcrypt_generic_init($td, $key, $iv);

        return $td;
    }

    private function urlSafeBase64Encode($data)
    {
        $data= base64_encode($data);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

        return $data;
    }

    private function urlSafeBase64Decode($data)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $data);
        $mod = strlen($data)%4;
        if ($mod) {
            $data .= substr('====', $mod);
        }

        return base64_decode($data);
    }
}