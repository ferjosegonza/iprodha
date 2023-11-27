<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lav_tc_tablero extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.lav_tc_tablero';

    protected $primaryKey = 'id_tc_tablero';
    
    public $incrementing = false;

    protected $fillable = [ 
        'id_tc_tablero',
        'nombre_tablero'
    ];

    public function getVistas(){
        return $this->hasMany(Lav_tc_vista::class,'id_tc_tablero', 'id_tc_tablero');
    }
}