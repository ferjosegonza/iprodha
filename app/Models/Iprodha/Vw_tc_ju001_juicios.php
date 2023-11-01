<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_ju001_juicios extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_ju001_juicios';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'altas',   
        'bajas',
        'archivo',
        'fecha_lectura'
    ];

    protected $attributes = [
        'mes' => false,
        'periodo' => false,
        'altas' => false,   
        'bajas' => false,
        'archivo' => false,
        'fecha_lectura' => false
    ];
    // protected $casts = [
    //     'fecha_lectura' => 'datetime:Y-m-d H:00',
    // ];

}