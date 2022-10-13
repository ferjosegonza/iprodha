<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Terrenos extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'iprodha.ter_terreno';
    protected $primaryKey = 'id_terterreno';
    public $incrementing = false;

    protected $fillable = [
        'id_etapa',
        'id_terterreno',
        'id_mun',
        'seccion',
        'chacra',
        'manzana',
        'parcela',
        'man_emp',
        'lote_emp',
        'calle',
        'finca',
        'superficie',
        'id_propietario',
        'dimension',
        'observacion',
        'orden',
        'idfinalidad',
        'nroplano',
        'idplano',
        'barrio',
        'adju',
        'posesion',
        'id_tipologia',
        'man_prov',
        'lote_prov',
        'partida'
    ];

    public function municipios() {
        return $this->belongsTo(Municipios::class,'id_mun');
    }
}
