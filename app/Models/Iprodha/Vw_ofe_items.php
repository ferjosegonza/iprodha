<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vw_ofe_items extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.vw_ofe_items';
  
    protected $fillable = [
        'idobra',
        'iditem',
        'orden',
        'nom_item',
        'cod_tipo',
        'nom_tipo',
        'por_inc',
        'vivienda',
        'infra'];
    protected $attributes = [
        'idobra'=> true,
        'iditem'=> true,
        'orden'=> true,
        'nom_item'=> true,
        'cod_tipo'=>true,
        'nom_tipo'=> true,
        'por_inc'=>true,
        'vivienda'=> true,
        'infra'=> true
    ];

    public function getSubItems()
    {
        return $this->hasMany(Ofe_subitem::class, 'iditem', 'iditem');
    }
}