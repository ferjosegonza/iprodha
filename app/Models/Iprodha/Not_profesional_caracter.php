<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_profesional_caracter extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.not_profesional_caracter';
    protected $primaryKey = 'id_caracter';

    protected $fillable = [ 
        'descripcion'
    ];

}