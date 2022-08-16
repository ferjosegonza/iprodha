<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Terreno extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'iprodha.ter_terreno';
    protected $primaryKey = 'id_terterreno';
    public $incrementing = false;

    protected $fillable = [
        'ID_ETAPA',
        'ID_TERTERRENO',
        'ID_MUN',
        'SECCION',
        'CHACRA',
        'MANZANA',
        'PARCELA',
        'MAN_EMP',
        'LOTE_EMP',
        'CALLE',
        'FINCA',
        'SUPERFICIE',
        'ID_PROPIETARIO',
        'DIMENSION',
        'OBSERVACION',
        'ORDEN',
        'IDFINALIDAD',
        'NROPLANO',
        'IDPLANO',
        'BARRIO',
        'ADJU',
        'POSESION',
        'ID_TIPOLOGIA',
        'MAN_PROV',
        'LOTE_PROV',
        'PARTIDA'
    ];
}
