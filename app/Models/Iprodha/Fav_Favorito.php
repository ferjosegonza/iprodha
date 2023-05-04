<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fav_Favorito extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.fav_favorito';
    protected $primaryKey = 'idfav';
    public $incrementing = false;

    protected $fillable = [ 
        'idfav', 'idusuario', 'ruta', 'descripcion', 'titulo',
    ];
}