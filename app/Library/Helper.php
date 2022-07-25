<?php
namespace App\Library;

use GuzzleHttp\Client;

class Helper {

    public static function sendSMS($mobile, $msg) {
        $client = new Client(['verify' => false ]);
        $client->request("GET", "http://66.45.237.70/api.php?username=01670168919&password=TVZMBN3D&number=". $mobile ."&message=".$msg);
    }

}