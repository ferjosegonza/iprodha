<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Exists;
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Unidad;


class Ofe_subitem extends Model
{
    use HasFactory;
    
    protected $table = 'iprodha.ofe_subitem';

    protected $primaryKey = 'idsubitem';
    
    public $incrementing = false;
    
    public $timestamps = false;
  
    protected $fillable = [ 
        'iditem',
        'idsubitem',
        'denominacion',
        'idunidad',
        'cantidad',
        'costounitario',
    ];

    // protected $attributes = [
    //     //'idobra' => false,
    //     //'idobra' => false,
    //     'iditem' => false,
    //     'idsubitem' => false,
    //     'denominacion' => false,
    //     'idunidad' => false,
    //     'cantidad' => false,
    //     'costounitario' => false,

    // ];

    public function getItem()
    {
        return $this->hasOne(Ofe_item::class,'iditem','iditem');
    }
    
    public function getUnidad()
    {
        return $this->belongsTo(Unidad::class,'idunidad','id_unidad')->withDefault([
            'unidad' => 'NO ESPECIFICADO',
        ]);
    }


    // protected function setKeysForSaveQuery($query)
    // {
    //     $query
    //         ->where('iditem', '=', $this->getAttribute('iditem'))
    //         ->where('idsubitem', '=', $this->getAttribute('idsubitem'));

    //     return $query;
    // }
}