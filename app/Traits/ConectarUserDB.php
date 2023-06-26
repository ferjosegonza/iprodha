<?php
namespace App\Traits;

use Illuminate\Support\Facades\Config;
use App\Models\Iprodha\Lav_user_db;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

trait ConectarUserDB
 {

    public function conectar()
    {
        // First purge the configuration to remove config details from cache 
        DB::purge('oracleuser');
        Config::set('database.connections.oracleuser.username', Lav_user_db::find(Auth::user()->id)->user_lav);
        Config::set('database.connections.oracleuser.password', Crypt::decryptString(Lav_user_db::find(Auth::user()->id)->pass_lav));
    }

 }