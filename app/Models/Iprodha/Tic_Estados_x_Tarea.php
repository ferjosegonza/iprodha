<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Estados_x_Tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_estados_x_tarea';
    protected $primaryKey = ['idestado', 'idtarea'];
    public $incrementing = false;

    protected $fillable = [ 
        'idtarea',  'idestado',  'fecha', 'observacion', 'estado_actual',
    ];
    
    public function getEstado()
    {
        return $this->belongsTo(Tic_Estado::class,'idestado','idestado');
    }

    public function getTicket(){
        return $this->belongsTo(Tic_Tarea::class, 'idtarea' , 'idtarea');
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('idestado', '=', $this->getAttribute('idestado'))
            ->where('idtarea', '=', $this->getAttribute('idtarea'));

        return $query;
    }
}