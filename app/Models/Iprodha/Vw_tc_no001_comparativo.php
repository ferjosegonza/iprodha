<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_no001_comparativo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_no001_comparativo';

    // protected $primaryKey = ['id_emp'];

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'anterior',   
        'actual'
    ];

}