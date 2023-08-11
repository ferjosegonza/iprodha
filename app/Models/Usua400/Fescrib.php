<?php

namespace App\Models\Usua400;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fescrib extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'USUA400.FESCRIB';
    protected $primaryKey = 'matricula';

    protected $fillable = [ 
        'codigo', 'nombre', 'cuit', 'activo', 'codloc', 'domici', 'ins_afip', 'fecha_venc',
        'email', 'fecha_alta_codigo', 'fecha_baja_codigo', 'estado', 'condicion', 'matricula_escribano',
        'nomusu', 'nro_cuenta', 'foto_id', 'reg_desde', 'reg_hasta', 'es_iprodha', 'idcaracter'
    ];

}