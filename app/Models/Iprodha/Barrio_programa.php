<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Barrio_programa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.PROGRAMA';
    //protected $primaryKey = 'IDTIPOLOGIA';
    //public $incrementing = true;

    protected $fillable = [ 
        'ID_PROGRAMA',
        'DESCRIPCION'
    ];
    protected $attributes = [
        'ID_PROGRAMA'=> true,
        'DESCRIPCION'=> true,
    ];
    /*public function obraBarrio()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obr');
    }*/
    /*public function localidadBarrio()
    {
        //return $this->belongsTo(Localidad::class,'id_loc','id_loc');
        return $this->hasMany(Barrio::class,'id_loc','id_loc');
    }*/
}
