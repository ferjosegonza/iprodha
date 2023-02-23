<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_ofe_cronograma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_ofe_cronograma';
    protected $primaryKey = 'idcrono';
    public $incrementing = false;

    protected $fillable = [ 
        'idcrono',
        'idobra',
        'iditem',   
        'nom_item',
        'costo',
        'por_inc',
        'mes',
        'avance',
        'incidencia',
        'importe',
        'poravaacuitem'
    ];

    protected $casts = [
        'avance' => 'decimal:4',
        'costo' => 'decimal:8',
        'por_inc' => 'decimal:4',
        'importe' => 'decimal:2',
        'poravaacuitem' => 'decimal:4'
    ];

}