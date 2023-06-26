<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Ob_situacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.ob_situacion';
    protected $primaryKey = 'id_situacion';

    public $incrementing = false;

    protected $fillable = [ 
        'id_situacion',
        'descripcion' 
    ];

    // protected $attributes = [
    //     'ID_OBRA' => false,
    // ];

}