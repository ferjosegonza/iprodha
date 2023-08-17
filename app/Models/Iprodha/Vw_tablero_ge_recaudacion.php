<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tablero_ge_recaudacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tablero_ge_recaudacion';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'fecha_lectura',
        'periodo',
        'cartera',   
        'pre_mora',
        'mora',
        'convenio',
        'recupero',
        'indice',
        'zona'
    ];

}