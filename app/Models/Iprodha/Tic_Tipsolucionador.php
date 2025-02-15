<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Tipsolucionador extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_tipsolucionador';
    protected $primaryKey = 'idtipsolucionador';
    public $incrementing = false;

    protected $fillable = [ 
        'idtipsolucionador',
        'destipsolucionador'
    ];
    
    public function getSolucionador()
    {
        return $this->hasMany(Tic_Solucionador::class,'idtipsolucionador','idtipsolucionador');
    }
    // public function solucionador()
    // {
    // return $this->belongsTo(Solucionador::class, 'idtipsolucionador');
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
