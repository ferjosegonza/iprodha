<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class BarrioCostos extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.fc_concosxbarrio';
    protected $primaryKey = 'BARRIO';//, IDORGANISMO, ID_CONCOSTO, CANTDORM, IDTIPOFAC, IDTIPOTERRE';
    public $incrementing = true;

    protected $fillable = [ 
        'BARRIO',
        'IDORGANISMO',
        'CONCOSTO',
        'SUMAORESTA',
        'IMPORTE',
        'ID_CONCOSTO',
        'CANTDORM',
        'IDTIPOFAC',
        'IDTIPOTERRE'


    ];
    protected $attributes = [
        'barrio' => false,
    ];
    /*public function obraBarrio()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obr');
    }*/
    /*public function barrioLocalidad()
    {
        return $this->belongsTo(Localidad::class,'id_loc','id_loc');
    }*/
    public function barriocostos_costosxbarrio()
    {
        return $this->hasMany(Barrio::class,'barrio','barrio');
    }


}
