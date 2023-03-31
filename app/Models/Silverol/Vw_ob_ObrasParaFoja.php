<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_ob_ObrasParaFoja extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_ob_obrasparafoja';
    protected $primaryKey = ['id_obr'];
    public $incrementing = false;

    protected $fillable = [ 
        'id_obr', 'nom_obr', 
        'num_obr', 'num_obr1',    
        'nom_loc', 'nom_emp',
        'cupo', 'foja'
    ];

}