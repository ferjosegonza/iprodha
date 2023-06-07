<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_digesto_areas extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.DIG_DIGESTO_AREAS';
    protected $primaryKey=['id_archivo','id_area'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_archivo','id_area'
    ];        

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_archivo', '=', $this->getAttribute('id_archivo'))
            ->where('id_area', '=', $this->getAttribute('id_area'));
        return $query;
    }

    public function guardar($id_archivo, $id_area){
        $this->id_archivo = $id_archivo;
        $this->id_area= $id_area;
        $res = $this->save();
        return $res;
    }

}