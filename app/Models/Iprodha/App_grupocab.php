<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_grupocab extends Model{

    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.app_grupocab';
    protected $primaryKey = 'id_grupo';
    
    protected $fillable = [ 
        'descripcion'
    ];
}