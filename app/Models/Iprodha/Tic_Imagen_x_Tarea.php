<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Imagen_x_Tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_imagen_x_tarea';
    protected $primaryKey = 'idimagen';
    public $incrementing = false;

    protected $fillable = [ 
        'idimagen',    'idtarea',
        'ruta'
    ];

    public function getTicket()
    {
        return $this->hasMany(Tic_Tarea::class,'idsolucionador','idsolucionador');
    }

    // public function tipo()
    // {
    //     return $this->hasOne(TipoSolucionador::class, 'idtipsolucionador', 'idsolucionador');
    // }
    
    // protected $maps = [
    //     'catlaboral' => 'nombre'
    // ];
    
    // protected $append = ['nombre'];

    // public function getNombreAttribute()
    // {
    //     return $this->attributes['catlaboral'];
    // }
}
