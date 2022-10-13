<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Ob_Conceptos extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.OB_CONCEPTOS';
    protected $primaryKey = 'ID_CONCEPTO';
    public $incrementing = false;

    protected $fillable = [ 
        'ID_CONCEPTO',
        'DESCRIPCION',
        'SIGNO',
        'UBICACION',
        'APLICA_F_REP',
        'MON_POR',
        'PORCENT',
        'ORDEN_PIE',
        'GRUPO_PIE'
    ];
    protected $attributes = [
        'ID_CONCEPTO' => true,
    ];
    

    public function scopeDescripcion($query,$descripcion)
    {
        if ($descripcion == '') {
            return $query;
        } else {
            return $query->where('descripcion','like','%'.$descripcion.'%'); 
        }          
    }

    /*
    NO VINCULO CON OTRAS TABLAS AUN. 
    */
}
