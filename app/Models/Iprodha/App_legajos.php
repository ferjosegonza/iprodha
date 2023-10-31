<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_legajos extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_legajos';
    protected $primaryKey = ['ope', 'barrio', 'adju'];
    public $incrementing = false;
    
    protected $fillable = [ 
        'operatoria', 'barrio', 'adju', 'nombre', 'cuil', 'situacion_habitacional', 'ope'
    ];

    protected function setKeysForSaveQuery($query)
     {
         $query
             ->where('ope', '=', $this->getAttribute('ope'))
             ->where('barrio', '=', $this->getAttribute('barrio'))
             ->where('adju', '=', $this->getAttribute('adju'));
         return $query;
    }
}