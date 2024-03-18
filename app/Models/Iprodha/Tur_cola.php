<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tur_cola extends Model{

    use HasFactory;
    
    public $timestamps = false;    
    protected $table = 'iprodha.tur_cola';
    protected $primaryKey = 'idcola';
    
    protected $fillable = [
        'descripcion', 'fecha_desde', 'fecha_hasta', 'cant_puestos', 'duracion_turno', 'idtramite', 'publicado'
    ];

    public function crear($descripcion, $desde, $hasta, $puestos, $duracion, $tramite){
        $this->descripcion = $descripcion;
        $this->fecha_desde = $desde;
        $this->fecha_hasta = $hasta;
        $this->cant_puestos = $puestos;
        $this->duracion_turno = $duracion;
        $this->idtramite = $tramite;
        $this->publicado = 0;
        return $this->save();
    }

}