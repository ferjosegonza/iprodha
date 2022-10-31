<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fav_Favorito extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'silverol.fav_favorito';
    protected $primaryKey = ['idusuario', 'ruta'];
    public $incrementing = false;

    protected $fillable = [ 
        'idusuario',    'ruta', 'descripcion', 'titulo',
    ];
    
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('idusuario', '=', $this->getAttribute('idusuario'))
            ->where('ruta', '=', $this->getAttribute('ruta'));
        return $query;
    }
}