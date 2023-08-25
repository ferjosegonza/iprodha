<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_re003_rangos extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_re003_rangos';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'fecha_lectura',
        'zona',
        'periodo',   
        'orden',
        'rango',
        'cantidad',
        'monto',
        'ubicacion'
    ];

}