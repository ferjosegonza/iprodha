<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_not_boletadisponible extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_not_boletadisponible';
    protected $primaryKey = ['ope', 'barrio', 'adju'];
    public $incrementing = false;
    
    protected $fillable = [
        'usuario', 'fecha', 'tipo', 'encabezado', 'mensaje'
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