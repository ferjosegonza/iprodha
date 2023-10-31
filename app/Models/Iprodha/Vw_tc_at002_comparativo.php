<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_at002_comparativo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_at002_comparativo';

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'generado',   
        'pagado',
        'importe',
        'fecha_lectura'
    ];

}