<?php

namespace  App\Utils;

class DateHelper
{


    public static function getAge($birthDate)
    {

        $now = date('m-d');
        $calc = date('m-d', strtotime($birthDate));

        if($now == $calc){
            $yearNow = date('Y');
            $yearCalc = date('Y', strtotime($birthDate));
            $years = ($yearNow - $yearCalc);
        }else{
            $date = new \DateTime( $birthDate );
            $interval = $date->diff( new \DateTime( date('Y-m-d') ) );
            $years = $interval->y;
        }

        return $years ;
    }

}