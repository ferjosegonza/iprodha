<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ofe_cronograma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.ofe_cronograma';
    protected $primaryKey = 'idcrono';
    public $incrementing = true;

    protected $fillable = [ 
        'idcrono', 'iditem', 'mes', 'avance', 'porcentaje',
    ];
    
    // public function getEstadoTarea()
    // {
    //     return $this->hasMany(Tic_Estados_x_Tarea::class,'idestado','idestado');
    // }
}