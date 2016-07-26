<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\UserInfo;

class MyFuncs {
        
    public static function lat_long($address){

        $address = str_replace(" ", "+", $address);
        //echo "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
        $json = json_decode($json);  
        $status = $json->{'status'};
        if($status == 'OK'){        
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        }else{
            $lat = '0.0';
            $long = '0.0';
        }
        return $lat.','.$long;
    }
    
    public static function get_date($day)
    {        
//        $date_of_day =  date( 'Y-m-d', strtotime( $day.' this week' ) );
        $date_of_day = date('Y-m-d', strtotime($day));
        return $date_of_day;
    }        
    public static function getRandomString($length = 9) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }
}
