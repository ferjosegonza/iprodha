<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Barrio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.BARRIO';
    protected $primaryKey = 'barrio';
    public $incrementing = true;

    protected $fillable = [ 
        'BARRIO',
        'NOMBARRIO',
        'ABRBARRIO',
        'ID_LOC',
        'FEC_ENTREGA',
        'FACTURA',
        'IDTIPBARRIO',
        'NRO_OBRA',
        'NRO_RES',
        'IDZONA',
        'ID_ENT',
        'PORFIN',
        'IDTIPOLOGIA',
        'ETAPA',
        'ENTREGA',
        'UBICACION',
        'VIEJO',
        'IDTIPOOBRA',
        'TIPOPRECIO',
        'OBS',
        'CANVIV',
        'CUENTABCO',
        'ID_PROGRAMA',
        'MTS1',
        'MTS2',
        'MTS3',
        'MTS4',
        'FECHA_ALTA',
        'TIPOFINAN',
        'PORC_FACTURA',
        'ID_OBR'

    ];
    protected $attributes = [
        'barrio' => false,
    ];
    /*public function obraBarrio()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obr');
    }*/
    public function barrioLocalidad()
    {
        return $this->belongsTo(Localidad::class,'id_loc','id_loc');
    }
    public function obraxbarrio()
    {
        return $this->hasOne(Obras::class,'id_obr','id_obr');
    }
}
