<?php
use Carbon\Carbon;
use App\Models\Iprodha\Lav_user_db;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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

if (! function_exists('base64url_encode')) {
    function base64url_encode($plainText)
    {
        return strtr(base64_encode($plainText), '+/=', '-_,');
    }
}

if (! function_exists('base64url_decode')) {
    function base64url_decode($b64Text)
    {
        return base64_decode(strtr($b64Text, '-_,', '+/='));
    }
}


    function setConnection()
    {
        $user = Lav_user_db::where("id_user_lav", Auth::user()->id)->first();
        return $oracleuser = [
            'driver'         => 'oracle',
            'tns'            => env('DB_TNS', ''),
            'host'           => env('DB_HOST', ''),
            'port'           => env('DB_PORT', '1521'),
            'database'       => env('DB_DATABASE', ''),
            'service_name'   => env('DB_SERVICENAME', ''),
            'username'       => $user->user_lav,
            'password'       => Crypt::decryptString($user->pass_lav),
            'charset'        => env('DB_CHARSET', 'AL32UTF8'),
            'prefix'         => env('DB_PREFIX', ''),
            'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
            'edition'        => env('DB_EDITION', 'ora$base'),
            'server_version' => env('DB_SERVER_VERSION', '11g'),
            'load_balance'   => env('DB_LOAD_BALANCE', 'yes'),
            'dynamic'        => [],
        ];
    }