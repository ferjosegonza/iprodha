<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iprodha\Ofe_subitem;

class Unidad extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'IPRODHA.UNIDAD';

    protected $primaryKey = 'id_unidad';   

    public $incrementing = false;
  
    protected $fillable = [ 
        'id_unidad',
        'unidad',
        
    ];

    public function getSubitem()
    {
        return $this->hasMany(Ofe_subitem::class,'idunidad','id_unidad');
    }
}