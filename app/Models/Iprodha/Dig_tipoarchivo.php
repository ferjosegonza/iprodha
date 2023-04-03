<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dig_tipoarchivos extends Model{
    use HasFactory;
    public$timestamps=false;        
    protected$table='iprodha.dig_tipoarchivos';
    protected$primaryKey='id_tipoarchivo';
    protected$fillable=[ 
        'id_tipocabecera', 'id_tipoarchivo', 'destipoarchivo', 'orden_imp', 'nombre_corto'
    ];        
}