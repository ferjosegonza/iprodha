<?php

namespace App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Historial extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='PERSONAL.HISTORIAL';
    protected $primaryKey='idhistorial';
    protected $fillable=[ 
        'idagente', 'fecha', 'detalle', 'observacion','orden'
    ];        
}