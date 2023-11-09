<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lav_tc_vista extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.lav_tc_vista';

    protected $primaryKey = 'id_tc_vista';
    
    public $incrementing = false;

    protected $fillable = [ 
        'id_tc_vista',
        'alias_vista',
        'nombre_vista',
        'id_tc_tablero'
    ];

    public function getTablero() {
        return $this->belongsTo(Lav_tc_tablero::class, 'id_tc_tablero', 'id_tc_tablero');
    }
}