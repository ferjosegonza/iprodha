<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Not_tramite extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.not_tramite';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'fecha', 'usuario', 'id_tipo', 'celular_contacto', 'mail_contacto', 'estado', 'nombre_comitente', 'dni_comitente'
    ];

    public function crearTramite($tipo, $cel, $mail, $nombre, $dni){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); 
        $this->fecha = date("Y-m-d h:i:s");
        $this->usuario = auth()->user()->name;
        $this->id_tipo = $tipo;
        if($cel != null){
            $this->celular_contacto = $cel;
        }
        if($mail != null){
            $this->mail_contacto = $mail;
        }
        $this->estado = 1;
        $this->nombre_comitente = $nombre;
        $this->dni_comitente = $dni;
        return $this->save();        
    }

    public function modificarTramite($tipo, $cel, $mail, $nombre, $dni){
        $this->id_tipo = $tipo;
        if($cel != null){
            $this->celular_contacto = $cel;
        }
        else{
            $this->celular_contacto = null;
        }
        if($mail != null){
            $this->mail_contacto = $mail;
        }
        else{
            $this->mail_contacto = null;
        }
        $this->estado = 1;
        $this->nombre_comitente = $nombre;
        $this->dni_comitente = $dni;
        return $this->save();        
    }
}