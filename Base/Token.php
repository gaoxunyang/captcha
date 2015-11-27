<?php
namespace Base;
class Token
{
    const STR_LEN = 4;
    const TOKEN_ELEMENT_COUNT = 3;

    public function build()
    {
        return $this->create();
    }

    private function create()
    {
        return sprintf("%s_%s_%s", $this->_randStr(self::STR_LEN), (string)(microtime(true)*10000), rand(1000, 9999));
    }

    private function _randStr($length)
    {
        $code = '';
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($str) -1;

        for ($i = 0; $i < $length; $i++) {
            $code .= $str[rand(0, $max)];
        }

        return $code;
    }
}