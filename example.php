<?php

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

require_once './vendor/autoload.php';

use HotelCrs\SecurityService;
use HotelCrs\ProfileService;

try {
    $res = new SecurityService();
    $session = $res->appLogin();
    // print_r($session);exit;
    $res = new ProfileService($session['SessionId']);

    $result = $res->getMemberInfoByTelephone('15036134165');
    // $result = $res->getPointAccrueListByTime('683000000033');
    // $result = $res->getAvailableCouponsByCardNoAndHotel('683000000033', '1002');
    print_r($result);
} catch (\Throwable $e) {
    print $e;
    // print $e->getMessage();
}
