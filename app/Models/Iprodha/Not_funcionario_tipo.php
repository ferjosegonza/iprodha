<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_funcionario_tipo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.NOT_FUNCIONARIO_TIPO';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [ 
        'descripcion'
    ];

}