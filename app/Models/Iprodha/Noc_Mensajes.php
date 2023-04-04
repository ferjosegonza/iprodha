<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Noc_Mensajes extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.noc_mensajes';
    protected $primaryKey = ['codigo'];
    public $incrementing = false;

    protected $fillable = [ 
        'codigo', 'mensaje', 'ruta', 'titulo'
    ];

    public function getNotificaciones()
    {
        return $this->hasMany(Noc_Notificacion::class, 'codigo' ,'codigo');
    }
}