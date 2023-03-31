<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sistemas_trigger_tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.sistemas_trigger_tarea';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'id',
        'tarea',
    ];
    
    public function getDetalle()
    {
        return $this->hasMany(Sistemas_trigger_det::class,'id','idtarea');
    }
}