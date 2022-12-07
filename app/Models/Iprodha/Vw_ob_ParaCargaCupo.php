<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_ob_ParaCargaCupo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_ob_paracargacupo';
    protected $primaryKey = ['id_obr'];
    public $incrementing = false;

    protected $fillable = [ 
        'num_obr',    'nom_obr',
        'id_obr',   
        'mes', 'periodo_o', 'cupo'
    ];

}