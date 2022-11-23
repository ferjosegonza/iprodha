<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_tarea';
    protected $primaryKey = 'idtarea';
    public $incrementing = false;

    protected $fillable = [ 
        'idtarea',    'idsolucionador',
        'idcatprobsub',   'descripciontarea',
        'usuario', 'iporigentarea', 'interno',
        'prioridad', 'tiempoestimado', 'idusuario',
    ];
    
    public function getSolucionador()
    {
        return $this->belongsTo(Tic_Solucionador::class,'idsolucionador','idsolucionador');
    }

    public function getCategoriaProb()
    {
        return $this->belongsTo(Tic_Catproblemasub::class, 'idcatprobsub','idcatprobsub');
    }

    public function getEstadoTarea()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getReasignacion()
    {
        // return $this->hasMany(TIC_Reasignaciontarea::class, 'idtarea' ,'idtarea');
        return $this->belongsTo(Tic_Reasignaciontarea::class, 'idtarea','idtarea');
    }

    public function getReasignacionVieja()
    {
        // return $this->hasMany(TIC_Reasignaciontarea::class, 'idtarea' ,'idtarea');
        return $this->belongsTo(Tic_Reasignaciontarea::class, 'idtarea_vieja','idtarea');
    }

    public function scopeCategoria($query,$categoria)
    {
        if ($categoria == '') {
            return $query;
        } else {
            // return $query->where('nombre','like','%'.$nombre.'%');
            return $query->whereIn('idcatprobsub', function ($query) use ($categoria){
                              $query->select('idcatprobsub')
                              ->from('iprodha.tic_catproblemasub')
                                 ->when($categoria != 0, function($query) use ($categoria){
                                     $query->where('idcatprob', $categoria);
                                 });
                             //  ->where('idcatprob', $categoria);
                             });
        }          
    }
    
    public function scopeEstado($query,$estado)
    {
        if ($estado == '') {
            return $query;
        } else {
            return $query->where('estado_actual', '=', $estado);
        }          
    }

    public function tareasPorEstado($estado){
        
    }
    // public function scopeCategoria($query,$categoria)
    // {
    //     if ($categoria == null) {
    //          return $query;  
    //     } else {
    //         return $query->where('idcatprob', '=', $categoria); 
    //     }          
    // }
}