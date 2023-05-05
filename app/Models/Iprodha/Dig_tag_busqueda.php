<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_tag_busqueda extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.DIG_TAG_BUSQUEDA';
    protected $primaryKey=['id_tag'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_tag', 'esquema', 'tabla', 'campo1', 'campo2'
    ];        
}