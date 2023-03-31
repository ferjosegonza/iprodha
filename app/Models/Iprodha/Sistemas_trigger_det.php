<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sistemas_trigger_det extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.sistemas_trigger_det';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'id',
        'id_trigger_act',
        'fecha',
        'usuario',
        'observacion',
        'idtarea',
    ];
    
    public function getEncabezado()
    {
        return $this->belongsTo(Sistemas_trigger_act::class, 'id_trigger_act', 'id');
    }

    public function getTarea(){
        return $this->belongsTo(Sistemas_trigger_tarea::class,'id','idtarea');
    }
}