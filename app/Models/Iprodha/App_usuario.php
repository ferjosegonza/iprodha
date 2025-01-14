<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_usuario extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_usuario';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'nombre', 'mail', 'usuario', 'fecha_creacion', 'token'
    ];

    public function crear($nombre, $mail, $usuario){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); 
        $this->nombre = $nombre;
        $this->mail = $mail;
        $this->usuario = $usuario;
        $this->fecha_creacion = date("Y-m-d h:i:s");
        return $this->save();
    }
}