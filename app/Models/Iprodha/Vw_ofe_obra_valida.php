<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vw_ofe_obra_valida extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.vw_ofe_obra_valida';
  
    protected $fillable = [
        'idobra',
        'nomobra',
        'nom_emp',
        'nom_loc',
        'tot1viv',
        'tot1inf'];
    protected $attributes = [
        'idobra'=> true,
        'nomobra'=> true,
        'nom_emp'=> true,
        'nom_loc'=> true,
        'tot1viv'=> true,
        'tot1inf'=> true
    ];

}