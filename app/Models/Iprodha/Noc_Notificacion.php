<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Noc_Notificacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.noc_notificacion';
    protected $primaryKey = 'idnotificacion';
    public $incrementing = false;

    protected $fillable = [ 
        'idnotificacion', 'idusuario', 
        'fecha', 'codigo', 'idestado'
    ];

    public function getMensaje(){
        return $this->belongsTo(Noc_Mensajes::class, 'codigo' , 'codigo');
    }
    public function getEstado(){
        return $this->belongsTo(Noc_Mensajes::class, 'idestado' , 'idestado');
    }
}