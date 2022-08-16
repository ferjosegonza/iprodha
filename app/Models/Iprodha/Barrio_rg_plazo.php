<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Barrio_rg_plazo extends Model
{
    use HasFactory;    
    public $timestamps = false;    
    protected $table = 'IPRODHA.RG_PLAZO';
    protected $primaryKey = 'plazo';//, IDORGANISMO, ID_CONCOSTO, CANTDORM, IDTIPOFAC, IDTIPOTERRE';
    public $incrementing = false;

    protected $fillable = [ 
        'PLAZO',
        'VENTA',
        'ALQUILER',
        'GASTOS_REG',
        'BARRIO_MEN',
        'BARRIO_ANUAL'
    ];
    protected $attributes = [
        'plazo' => false,
    ];
    /*public function obraBarrio()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obr');
    }*/
    /*public function barrioLocalidad()
    {
        return $this->belongsTo(Localidad::class,'id_loc','id_loc');
    }*/
    /*public function Barrio_rg_plazo_costosxbarrio()
    {
        return $this->hasMany(Barrio::class,'barrio','barrio');
    }*/
}
