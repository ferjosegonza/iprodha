<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Iprousuario extends Model
{
    use HasFactory;
    public $timestamps = true;
    
    protected $table = 'system.usuarios';


    protected $fillable = [
        'nomcom',
        'nomusu',
        'clausu',
        'codare',
        'feccre',
        'feccad',
        'estado',
        'ip',
        'terminal',
        'sid',
        'iniusu'
    ];
    

}
