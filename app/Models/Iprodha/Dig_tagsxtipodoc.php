<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dig_tagsxtipodoc extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.dig_tagsxtipodoc';
    protected $primaryKey=['id_tipoarchivo', 'id_subtipoarchivo', 'id_tipocabecera', 'id_tag'];
    public $incrementing = false;
    protected $fillable=[ 
        'id_tipoarchivo', 'id_subtipoarchivo', 'id_tipocabecera', 'id_tag', 'id_tipo'
    ];        
}