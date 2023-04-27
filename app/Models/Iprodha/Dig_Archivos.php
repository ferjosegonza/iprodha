<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_archivos extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_archivos';
    protected $primaryKey=['id_archivo'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_archivo','id_tipoarchivo','id_subtipoarchivo', 'ano_archivo', 'mes_archivo', 'dia_archivo', 'nro_archivo',
        'claves_archivo', 'path_archivo', 'nombre_archivo', 'fecha_carga', 'id_tipocabecera', 'fecha_boletin',
        'orden', 'destipoarchivo', 'orden_imp'
    ];        
}