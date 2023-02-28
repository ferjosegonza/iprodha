<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Exists;
/*use App\Models\ME\Expediente;
use App\Models\Iprodha\Ofe_item;
use App\Models\Iprodha\Ofe_obra;*/
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Ofe_unidad;


class Ofe_subitem extends Model
{
    use HasFactory;
    
    protected $table = 'iprodha.Ofe_subitem';
    protected $primaryKey = ['iditem','idsubitem'];
    //protected $primaryKey = array('iditem','idsubitem');
    public $incrementing = false;
    
    public $timestamps = false;
  
    protected $fillable = [ 
        //'idobra',
        'iditem',
        'idsubitem',
        'denominacion',
        'idunidad',
        'cantidad',
        'costounitario',
    ];
    protected $attributes = [
        //'idobra' => false,
        //'idobra' => false,
        'iditem' => false,
        'idsubitem' => false,
        'denominacion' => false,
        'idunidad' => false,
        'cantidad' => false,
        'costounitario' => false,

    ];

    public function getItem()
    {
        return $this->hasOne(Ofe_item::class,'iditem','iditem');
    }
    /*public function getObra()
    {            
        return $this->hasMany(Ofe_obra::class,'idobra','idobra');
    }*/
    public function getUnidad()
    {
        return $this->belongsTo(Ofe_unidad::class,'idunidad','idunidad')->withDefault([
            'unidad' => 'NO ESPECIFICADO',
        ]);
    }


    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('iditem', '=', $this->getAttribute('iditem'))
            ->where('idsubitem', '=', $this->getAttribute('idsubitem'));

        return $query;
    }
}