<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'silverol.tic_tarea';
    protected $primaryKey = 'idtarea';
    public $incrementing = false;

    protected $fillable = [ 
        'idtarea',    'idsolucionador',
        'idcatprobsub',   'descripciontarea',
        'usuario', 'iporigentarea', 'interno',
        'prioridad', 'tiempoestimado'
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
    // public function scopeCategoria($query,$categoria)
    // {
    //     if ($categoria == null) {
    //          return $query;  
    //     } else {
    //         return $query->where('idcatprob', '=', $categoria); 
    //     }          
    // }
}