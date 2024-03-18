<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tur_horarioxcola extends Model{

    use HasFactory;
    
    public $timestamps = false;    
    protected $table = 'iprodha.tur_horarioxcola';
    protected $primaryKey = 'idhorario';
    
    protected $fillable = [
        'idcola', 'dia', 'hora_desde', 'minuto_desde', 'hora_hasta', 'minuto_hasta'
    ];

    public function crear($idcola, $dia,$horaDesde, $minDesde, $horaHasta, $minHasta){
        $this->idcola = $idcola;
        $this->dia = $dia;
        $this->hora_desde = $horaDesde;
        $this->minuto_desde = $minDesde;
        $this->hora_hasta = $horaHasta;
        $this->minuto_hasta = $minHasta;
        return $this->save();
    }

}