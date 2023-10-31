<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_tc_no001_historico extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_tc_no001_historico';

    public $incrementing = false;

    protected $fillable = [ 
        'mes',
        'periodo',
        'a2016',   
        'a2017',
        'a2018',
        'a2019',
        'a2020',
        'a2021',
        'a2022',
        'a2023',
        'a2024'
    ];

    

}