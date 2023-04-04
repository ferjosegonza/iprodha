<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_subtipoarchivo extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_subtipoarchivo';
    protected $primaryKey=['id_tipoarchivo','id_subtipoarchivo'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_tipocabecera', 'id_tipoarchivo','id_subtipoarchivo', 'dessubtipoarchivo', 'orden_imp', 'nombre_corto'
    ];        

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_tipoarchivo', '=', $this->getAttribute('id_tipoarchivo'))
            ->where('id_subtipoarchivo', '=', $this->getAttribute('id_subtipoarchivo'));
        return $query;
    }
}