<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Municipios extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'iprodha.municipio';
    protected $primaryKey = 'id_municipio';
    public $incrementing = false;

    protected $fillable = [
        'id_municipio',
        'nom_municipio',
        'tasa_municipal',
        'id_departamento',
        'nro_cuenta',
        'localidad',
        'nom_intendente',
        'dom_muni',
        'anses',
        'nom_abr',
        'anses_id_param',
        'longitud',
        'latitud',
        'electores',
        'dir_postal',
        'prefijo_tel'
    ];

    public function terrenos() {
        return $this->hasMany(Terrenos::class,'id_municipio');
    }
}
