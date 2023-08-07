<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.not_tramite';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'fecha', 'usuario', 'id_tipo', 'celular_contacto', 'mail_contacto', 'estado', 'nombre_comitente', 'dni_comitente'
    ];

}