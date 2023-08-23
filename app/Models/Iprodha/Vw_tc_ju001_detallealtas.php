<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_ju001_detallealtas extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_ju001_detallealtas';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'periodo',
        'mes',
        'aÑoexp',   
        'nroexp',
        'codjuz',
        'tipjuz',
        'codsec',
        'ope',
        'barrio',
        'adju',
        'nombre',
        'localidad',
        'ubicacion',
        'situacion'
    ];


}