<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iprodha\Ofe_obra;

class Ofe_item extends Model
{
    use HasFactory;   

    public $timestamps = false; 

    public $incrementing = false;

    protected $table = 'iprodha.ofe_item';

    protected $primaryKey = 'iditem';
  
    protected $fillable = [ 
        'idobra',
        'iditem',
        'nom_item',
        'costo',
        'por_inc',
        'codigo',
        'cod_tipo',
        'orden',        
    ];
    protected $attributes = [
        'idobra' => false,
        'iditem' => false,
    ];
    
    public function getObra()
    {
        return $this->belongsTo(Ofe_obra::class, 'idobra', 'idobra');
    }
    public function getSubItems()
    {
        return $this->hasMany(Ofe_subitem::class, 'iditem', 'iditem');
    }
    public function getCronograma()
    {
        return $this->hasMany(Ofe_cronograma::class, 'iditem', 'iditem');
    }
}