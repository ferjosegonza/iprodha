<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tur_tramite extends Model{

    use HasFactory;
    
    public $timestamps = false;    
    protected $table = 'iprodha.tur_tramite';
    protected $primaryKey = 'idtramite';
    
    protected $fillable = [
        'denominacion'
    ];

}