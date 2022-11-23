<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iprodha\Ofe_subitem;

class Ofe_unidad extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'IPRODHA.OFE_UNIDAD';
    //protected $primaryKey = ['iditem','idsubitem'];
    protected $primaryKey = 'idunidad';    
    public $incrementing = true;
  
    protected $fillable = [ 
        'idunidad',
        'unidad',
        
    ];
    protected $attributes = [
        'idunidad' => false,
    ];
    public function getSubitem()
    {
        return $this->hasMany(Ofe_subitem::class,'idunidad','idunidad');
    }
}
