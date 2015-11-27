<?php
require "CaptchaLogic.php";

$tokenLogic = new CaptchaLogic();
echo $tokenLogic->getCaptch();