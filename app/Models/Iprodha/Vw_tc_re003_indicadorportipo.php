<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_re003_indicadorportipo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_re003_indicadorportipo';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'fecha_lectura',
        'id_zona',
        'periodo',   
        'tipologia',
        'cartera_deuda',
        'premora',
        'mora',
        'recupero_ge',
        'indice',
        'legajos',
        'zona'
    ];

}