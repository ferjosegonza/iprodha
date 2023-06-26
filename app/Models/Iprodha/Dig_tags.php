<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_tags extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_tags';
    protected $primaryKey=['id_tag'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_tag', 'descripcion', 'estructura', 'dato'
    ];        
}