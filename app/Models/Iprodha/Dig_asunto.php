<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_asunto extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_asunto';
    protected $primaryKey='id_archivo';
    public $incrementing = false;
    protected $fillable=[ 
        'id_archivo', 'asunto'
    ];        
}