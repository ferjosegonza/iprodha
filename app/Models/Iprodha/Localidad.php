<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Localidad extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.LOCALIDAD';
    protected $primaryKey = 'ID_LOC';
    public $incrementing = true;

    protected $fillable = [ 
        'ID_LOC',
        'NOM_LOC',
        'ID_MUN',
        'CP',
        'LOC_VIEJA',
        'POBLACION',
        'COD_INDEC',
        'KMS_POS',
        'COD_TABLERO',
        'ID_LOC_HACIENDA',
        'LONGITUD',
        'LATITUD',
        'GRUPO_OCA'
    ];
    protected $attributes = [
        'ID_LOC' => false,
        /*'NOM_LOC' => false,
        'ID_MUN' => false,
        'CP' => false,
        'LOC_VIEJA' => false,*/

    ];
    /*public function obraBarrio()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obr');
    }*/
    public function localidadBarrio()
    {
        //return $this->belongsTo(Localidad::class,'id_loc','id_loc');
        return $this->hasMany(Barrio::class,'id_loc','id_loc');
    }

    public function getEtapas(){
        return $this->hasMany(Ob_etapa::class,'id_localidad','id_loc');
    }

    public function getObras(){
        return $this->hasMany(Ob_obra::class, 'id_loc', 'id_loc');
    }

    public function getViviendas(){
        return $this->hasMany(Ob_vivienda::class,'id_loc', 'id_loc');
    }

    public function getMunicipio() {
        return $this->belongsTo(Municipios::class, 'id_mun', 'id_municipio');
    }
}
