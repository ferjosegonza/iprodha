<?php

namespace App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vw_dig_areas extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='PERSONAL.VW_DIG_AREAS';
    protected $primaryKey='idarea';
    public $incrementing = false;
    protected $fillable=[ 
        'idarea', 'area','nivel'
    ];        
}