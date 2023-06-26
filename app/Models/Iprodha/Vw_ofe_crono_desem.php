<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_ofe_crono_desem extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_ofe_crono_desem';
    protected $primaryKey = 'idcrono';
    public $incrementing = false;

    protected $fillable = [ 
        'idobra',
        'mes',
        'costo',
    ];

    // protected $casts = [
    //     'costo' => 'decimal:2',
    // ];

}