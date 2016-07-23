<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\UserInfo;

class MyFuncs {
        
    public static function lat_long($address){

        $address = str_replace(" ", "+", $address);
        //echo "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";exit;
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
        $json = json_decode($json);     
        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        return $lat.','.$long;
    }
    
    public static function get_date($day)
    {        
        $date_of_day =  date( 'Y-m-d', strtotime( $day.' this week' ) );
        return $date_of_day;
    }        
}
