<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_digesto extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_digesto';
    protected $primaryKey=['id_archivo0','id_archivon'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_archivo0', 'id_archivon','observacion'
    ];        

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_archivo0', '=', $this->getAttribute('id_archivo0'))
            ->where('id_archivon', '=', $this->getAttribute('id_archivon'));
        return $query;
    }

    public function guardar($id0, $idn, $obs){
        $this->id_archivo0 = $id0;
        $this->id_archivon = $idn;
        $this->observacion = $obs;
        $res = $this->save();
        return $res;
    }

}