<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_pat_paracargarubro extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.vw_pat_paracargarubro';
    protected $primaryKey = ['id_emp'];
    public $incrementing = false;

    protected $fillable = [ 
        'id_emp',
        'cuit',
        'nom_emp',   
        'direccion',
    ];

}