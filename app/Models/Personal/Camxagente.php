<?php

namespace App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Camxagente extends Model{
    use HasFactory;
    public $timestamps=false;        
    public $incrementing=false;
    protected $table='PERSONAL.CAMXAGENTE';
    protected $primaryKey=['idagente', 'idcambio'];
    protected $fillable=[ 
        'valoranterior', 'feccambio', 'idquecambia', 'valoractual', 'obs'
    ];   
    protected function setKeysForSaveQuery($query){
        $query
        ->where('idagente','=',$this->getAttribute('idagente'))
        ->where('idcambio','=',$this->getAttribute('idcambio'));
        return $query;
    }     
    public function asentarNovedadDetalle($old, $new, $id){       
        date_default_timezone_set('America/Argentina/Buenos_Aires'); 
        $detalle = new Camxagente;
        $query = "select max(idcambio) as id from PERSONAL.CAMXAGENTE where idagente= $id";
        $cambio = DB::select( DB::raw($query));
        $detalle->idcambio=$cambio[0]->id + 1;
        $detalle->idagente = $id;
        $detalle->valoranterior = $old;
        $detalle->valoractual = $new;
        $detalle->feccambio =  date('Y-m-d');
        $detalle->idquecambia = 37;
        $detalle->obs = 'REGISTRO EL CAMBIO: ' . auth()->user()->name . ' - ' .  date("Y-m-d h:i:s");      
        return $detalle;
    }
    public function asentarNovedadFecha($old, $new, $id){        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $detalle = new Camxagente;
        $query = "select max(idcambio) as id from PERSONAL.CAMXAGENTE where idagente= $id";
        $cambio = DB::select( DB::raw($query));
        $detalle->idcambio=$cambio[0]->id + 1;
        $detalle->idagente = $id;
        $detalle->valoranterior = date('Y-m-d',strtotime($old));
        $detalle->valoractual = $new;
        $detalle->feccambio =  date('Y-m-d');
        $detalle->idquecambia = 40;
        $detalle->obs = 'REGISTRO EL CAMBIO: ' . auth()->user()->name . ' - ' .  date("Y-m-d h:i:sa");    
        return $detalle;
    }
    public function asentarNovedadOBS($old, $new, $id){    
        date_default_timezone_set('America/Argentina/Buenos_Aires');    
        $detalle = new Camxagente;
        $query = "select max(idcambio) as id from PERSONAL.CAMXAGENTE where idagente= $id";
        $cambio = DB::select( DB::raw($query));
        $detalle->idcambio=$cambio[0]->id + 1;
        $detalle->idagente = $id;
        $detalle->valoranterior = $old;
        $detalle->valoractual = $new;
        $detalle->feccambio = date('Y-m-d');
        $detalle->idquecambia = 39;
        $detalle->obs = 'REGISTRO EL CAMBIO: ' . auth()->user()->name . ' - ' .  date("Y-m-d h:i:sa");        
        return $detalle;
    }
    public function asentarArchivos($old, $new, $id){     
        date_default_timezone_set('America/Argentina/Buenos_Aires');   
        $detalle = new Camxagente;
        $query = "select max(idcambio) as id from PERSONAL.CAMXAGENTE where idagente= $id";
        $cambio = DB::select( DB::raw($query));
        $detalle->idcambio=$cambio[0]->id + 1;
        $detalle->idagente = $id;
        $detalle->valoranterior = $old;
        $detalle->valoractual = $new;
        $detalle->feccambio = date('Y-m-d');
        $detalle->idquecambia = 38;
        $detalle->obs = 'REGISTRO EL CAMBIO: ' . auth()->user()->name . ' - ' .  date("Y-m-d h:i:sa");        
        return $detalle;
    }
}