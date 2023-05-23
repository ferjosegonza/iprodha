<?php
use Carbon\Carbon;

$DBuser = 'hola';

if (! function_exists('convertLocalToUTC')) {
    function convertLocalToUTC($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'Europe/Paris')->setTimezone('UTC');
    }
}

if (! function_exists('convertUTCToLocal')) {
    function convertUTCToLocal($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC')->setTimezone('Europe/Paris');
    }
}

if (! function_exists('setDBuser')) {
    function setDBuser($user, $pass)
    {
        GLOBAL $DBuser;
        return $DBuser = $user;
    }
}

if (! function_exists('getDBuser')) {
    function getDBuser()
    {
        GLOBAL $DBuser;
        return $DBuser;
    }
}