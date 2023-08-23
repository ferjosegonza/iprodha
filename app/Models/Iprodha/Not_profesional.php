<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_profesional extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.not_profesional';
    protected $primaryKey = 'id_profesional';

    protected $fillable = [ 
        'descripcion'
    ];

}