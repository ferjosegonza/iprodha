<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_no001_escrituras extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_no001_escrituras';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'barrio',
        'adju',
        'nombre',   
        'fecha',
        'tipo',
        'localidad',
        'fechalta',
        'mes',
        'ubicacion',
        'periodo',
        'ope',
        'fecha_lectura'
    ];

}