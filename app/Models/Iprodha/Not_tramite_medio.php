<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_medio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_MEDIO';
    protected $primaryKey = 'id_medio';

    protected $fillable = [ 
        'descripcion'
    ];

}