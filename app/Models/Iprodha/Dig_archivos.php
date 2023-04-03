<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dig_archivos extends Model{
    use HasFactory;
    public$timestamps=false;        
    protected$table='iprodha.dig_archivos';
    protected$primaryKey='id_archivo';
    protected$fillable=[ 
        'id_archivo', 'id_tipoarchivo', 'id_subtipoarchivo', 'ano_archivo', 'mes_archivo', 'dia_archivo',
        'claves_archivo', 'path_archivo', 'nombre_archivo', 'fecha_carga', 'id_tipocabecera', 'fecha_boletin',
        'orden'
    ];        
}