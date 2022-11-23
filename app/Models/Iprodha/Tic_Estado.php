<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Estado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_estado';
    protected $primaryKey = 'idestado';
    public $incrementing = false;

    protected $fillable = [ 
        'idtarea',    'denestado', 'activo', 'ordvisualiz',
    ];
    
    public function getEstadoTarea()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class,'idestado','idestado');
    }
}