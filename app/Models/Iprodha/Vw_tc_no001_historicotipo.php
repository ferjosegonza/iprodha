<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_no001_historicotipo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_no001_historicotipo';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'aÑo',
        'tipo',
        'cantidad'
    ];

    protected $attributes = [
        'aÑo' => false,
        'tipo' => false,
        'cantidad' => false
    ];

}