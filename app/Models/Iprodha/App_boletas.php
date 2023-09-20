<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_boletas extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_boletas';
    protected $primaryKey = ['ope', 'barrio', 'adju', 'nro_cta'];
    public $incrementing = false;
    
    protected $fillable = [ 
        'ope', 'barrio', 'adju', 'ult_fac', 'fecha_vto', 'nro_cta', 'importe', 'estado'
    ];

    protected function setKeysForSaveQuery($query)
     {
         $query
             ->where('ope', '=', $this->getAttribute('ope'))
             ->where('barrio', '=', $this->getAttribute('barrio'))
             ->where('adju', '=', $this->getAttribute('adju'))
             ->where('nro_cta', '=', $this->getAttribute('nro_cta'));
         return $query;
    }
}