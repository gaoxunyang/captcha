<?php
require "CaptchaLogic.php";

$token = $_GET['token'];
$code = $_GET['code'];

$captchaLogic = new CaptchaLogic();
var_dump($captchaLogic->verifyCaptcha($token, $code));