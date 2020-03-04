<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;


class Utilities extends Component
{
    public static function howLongAgo($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
            return '0 seconds';

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
            );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
            );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    public static function secondsToHMS($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        return $hours . "h " . $minutes . "m " . $seconds . "s";
    }

    public static function secondsToHM($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        return $hours . "h " . $minutes . "m";
    }

    public static function secondsToH($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        return $hours;
    }

    public static function getColourFromCss($class)
    {
        if ($class == "danger")
            return "red";
        if ($class == "warning")
            return "orange";
        if ($class == "success")
            return "green";
        if ($class == "info")
            return "aqua";
        if ($class == "primary")
            return "blue";
            
        return "white";
    }

    public static function getLastFridayOfMonth($unix)
    {
        $endOfMonth = strtotime(date("Y-m-t", $unix));
        // Only try 7 times, 7 days etc, don't want a potential error forever loop.
        for ($i = 0; $i < 7; $i++) {
            $dayUnix = $endOfMonth - ($i * 86400);
            if (date("N", $dayUnix) == 5) return $dayUnix;
        }

        return null;
    }

    public static function getFirstFridayOfMonth($unix)
    {
        $startOfMonth = strtotime(date("Y-m-1", $unix));
        // Only try 7 times, 7 days etc, don't want a potential error forever loop.
        for ($i = 0; $i < 7; $i++) {
            $dayUnix = $startOfMonth + ($i * 86400);
            if (date("N", $dayUnix) == 5) return $dayUnix;
        }

        return null;
    }

    public static function postcodeValid($postcode)
    {
        $postcode = preg_replace('/\s/', '', $postcode);
        $postcode = strtoupper($postcode);
     
        if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postcode)
            || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postcode)
            || preg_match("/^GIR0[A-Z]{2}$/",$postcode)){
            return true;
        } else {
            return false;
        }
    }

    public static function postcodechecker($postcode)
    {
        $postcode = preg_replace('/\s/', '', $postcode);
        $postcode = strtoupper($postcode);
     
        if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postcode)
            || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postcode)
            || preg_match("/^GIR0[A-Z]{2}$/",$postcode)){
            return true;
        } else {
            return false;
        }
    }

    public static function getFilename($prefix = null, $extension = null, $length = 10) 
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        $key = $key. '-'. time();

        if ($extension)
            $key = $key.'.'.$extension;

        if ($prefix)
            $key = $prefix.'-'.$key;

        return $key;
    }

    public static function getRandomString($customer = null, $time = null, $length = 10)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }   

        if ($customer)
            $key = $key. '-'. $customer;

        if ($time)
            $key = $key. '-'. $time;

        return $key;
    }
}