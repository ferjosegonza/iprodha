<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_not_x_usuario extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_not_x_usuario';
    protected $primaryKey = 'id_notificacion';
    
    protected $fillable = [ 
        'grupo', 'usuario', 'fecha', 'id_tipo', 'encabezado', 'mensaje'
    ];
}