<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_tipo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.not_tramite_tipo';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [ 
        'descripcion'
    ];

}