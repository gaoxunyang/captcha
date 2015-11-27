<?php
header("Content-type: image/png;charset=gb2312");
require "CaptchaLogic.php";

$token = $_GET['token'];

$captchaLogic = new CaptchaLogic();
$captchaLogic->getCaptchImg($token);