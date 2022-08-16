<?php

namespace App\Models\Quique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Conceptofacturacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'quique.fc_concepto';
    protected $primaryKey = 'idconcepto';
    public $incrementing = false;

    protected $fillable = [ 
        'idconcepto',    'concepto',
        'monpor',   'sumaoresta',
        'nrofila',   'nrocolumna',
        'fechabaja',  'va_enxadju',
        've_cr',    've_bn',
        've_mv',   've_ch',
        'forma_cap',   've_pi',
        've_notacre',   've_adel_canc',
        've_ah',    'forma_neta',
        'enmascara',   've_readju_comun',
        've_readju_entreper',   'modifica_nouvi',
        'modifica_uvi',    'es_capital',
        'es_deuda_cap',   'forma_pura',
        'forma_aq',    'forma_recargo'
    ];
    

}
