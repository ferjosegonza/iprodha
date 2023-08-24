<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_movimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_MOVIMIENTO';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [ 
        'id_tramite', 'fecha', 'observacion', 'id_medio', 'usuario'
    ];

    public function crear($id, $obs, $medio){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); 
        $this->id_tramite = $id;
        $this->fecha = date("Y-m-d h:i:s");
        $this->observacion= $obs;
        $this->id_medio = $medio;
        $this->usuario = auth()->user()->name;
        return $this->save();
    }

}