<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_not_tipo extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_not_tipo';
    protected $primaryKey = 'id_tipo';
    
    protected $fillable = [ 
        'descripcion', 'forma'
    ];
}