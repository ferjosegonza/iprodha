<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_re003_ultimoindicador extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_re003_ÚltimoIndicador';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'periodo',
        'alem',
        'eldorado',   
        'obera',
        'indice',
        'cartera',
        'recupero'
    ];

}