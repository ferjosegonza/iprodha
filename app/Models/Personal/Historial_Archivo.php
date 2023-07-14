<?php

namespace App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Historial_Archivo extends Model{
    use HasFactory;
    public $timestamps=false;        
    public $incrementing=false;
    protected $table='PERSONAL.HISTORIAL_ARCHIVO';
    protected $primaryKey=['idhistorial', 'idarchivo'];
    protected $fillable=[ 
        'idhistorial','idarchivo'
    ];        
    protected function setKeysForSaveQuery($query){
        $query
        ->where('idhistorial','=',$this->getAttribute('idhistorial'))
        ->where('idarchivo','=',$this->getAttribute('idarchivo'));
        return $query;
    }
}