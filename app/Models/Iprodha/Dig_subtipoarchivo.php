<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dig_subtipoarchivos extends Model{
    use HasFactory;
    public$timestamps=false;        
    protected$table='iprodha.dig_subtipoarchivos';
    protected$primaryKey=['id_tipoarchivo','id_subtipoarchivo'];
    protected$fillable=[ 
        'id_tipocabecera', 'id_tipoarchivo','id_subtipoarchivo', 'dessubtipoarchivo', 'orden_imp', 'nombre_corto'
    ];        

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('idusuario', '=', $this->getAttribute('idusuario'))
            ->where('ruta', '=', $this->getAttribute('ruta'));
        return $query;
    }
}