<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EstadoObras extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_presi_pagosobras';
    protected $primaryKey = 'idconcepto';
    public $incrementing = false;

    protected $fillable = [ 
        'num_obr',    'nom_obr',
        'nroobra',   'nom_emp',
        'nom_loc',   'fec_emi',
        'periodo',  'nro_cer_pag',
        'id_op',    'moncontrato',
        'operatoria',   'totcertif',
        'apagar',   'totpagado',
        'totimpuestos',   'saldoapagar',
        'doc_id',    'ordenpago'
    ];
    


    public function scopeEmpresa($query,$empresa)
    {
        if ($empresa == '' || $empresa== 'Empresas') {
            return $query;  
        } else {
            return $query->where('nom_emp',$empresa); 
        }          
    }

    public function scopePrograma($query,$programa)
    {
        if ($programa == '' || $programa== 'Programas') {
            return $query;  
        } else {
            return $query->where('operatoria',$programa); 
        }          
    }

}
