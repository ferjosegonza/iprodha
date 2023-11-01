<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_at001_cancelaciones extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_at001_cancelaciones';

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'ope',   
        'barrio',
        'adju',
        'nombre',
        'dni',
        'plan',
        'plazo',
        'dormitorios',
        'situacion',
        'tipo_adju',
        'fecha_can',
        'tipo',
        'cuota',
        'escritura',
        'localidad',
        'ubicacion',
        'pagado',
        'fecha_lectura',
        'mescan'
    ];

}