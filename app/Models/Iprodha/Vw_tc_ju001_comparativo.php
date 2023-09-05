<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_ju001_comparativo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_ju001_comparativo';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'altas_22',   
        'bajas_22',
        'altas_23',
        'bajas_23',
        'archivo',
        'fecha_lectura'
    ];

}