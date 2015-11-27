<?php
require "Base/Cache.php";
require "Base/Encryption.php";
require "Base/Img.php";
require "Base/Token.php";
use Base\Token;
use Base\Encryption;
use Base\Img;
use Base\Cache;
class CaptchaLogic
{
    const CAPTCH_EXPTIME = 30;
    const CAPTCH_BLACKLIST_EXPTIME = 60;
    const CAPTCH_BLACKLIST = "captcha_black_%s";

    public function getCaptch()
    {
        //build token
        $token = new Token();
        $token = $token->build();
        $str = Encryption::encode($token);

        return $str;
    }

    public function getCaptchImg($token)
    {
        //У��token
        if (!$code = $this->_verifyToken($token)) {
            return false;
        }

        //У�������
        if (Cache::getInstance()->get(md5($token))) {
            return false;
        }

        //У��ɹ������������
        Cache::getInstance()->set(md5($token), 1, self::CAPTCH_BLACKLIST_EXPTIME);

        //���ط�����֤��ͼƬ
        $image = new Img(60, 20);
        $image->getCapcha($code);
    }

    public function verifyCaptcha($token, $captchaCode)
    {
        //����
        if (!$code = $this->_verifyToken($token)) {
            return false;
        }

        //��������
        if (Cache::getInstance()->get(sprintf(self::CAPTCH_BLACKLIST, md5($token)))) {
            return false;
        }

        //���������
        Cache::getInstance()->set(sprintf(self::CAPTCH_BLACKLIST, md5($token)), 1, self::CAPTCH_BLACKLIST_EXPTIME);

        if (strtolower($code) == strtolower($captchaCode)) {
            return true;
        }

        return false;
    }

    private function _verifyToken($token)
    {
        //����
        $str = Encryption::decode($token);
        $strArr = explode('_', $str);
        if (count($strArr) != Token::TOKEN_ELEMENT_COUNT) {
            return false;
        }

        if (time() - $strArr[1] > self::CAPTCH_EXPTIME) {
            return false;
        }

        return $strArr[0];
    }
}