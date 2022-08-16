<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Solucionador extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'silverol.tic_solucionador';
    protected $primaryKey = 'idsolucionador';
    public $incrementing = false;

    protected $fillable = [ 
        'idsolucionador',    'nombre',
        'idtipsolucionador'
    ];
    
    public function getTipo()
    {
        return $this->belongsTo(TipoSolucionador::class,'idtipsolucionador','idtipsolucionador');
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
