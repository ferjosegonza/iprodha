<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tur_turno extends Model{

    use HasFactory;
    
    public $timestamps = false;    
    protected $table = 'iprodha.tur_turno';
    protected $primaryKey = 'idturno';
    
    protected $fillable = [
        'idcola', 'fecha', 'hora', 'minuto', 'puesto', 'dni'
    ];

    public function crear($idcola, $fecha, $hora, $minuto, $puesto, $dni){
        $this->idcola = $idcola;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->minuto = $minuto;
        $this->puesto = $puesto;
        $this->dni = $dni;
        return $this->save();
    }

}