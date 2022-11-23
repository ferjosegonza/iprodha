<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofe_conceptosombrero extends Model
{
    use HasFactory;
    protected $table = 'IPRODHA.OFE_CONCEPTOSOMBRERO';
    protected $primaryKey = 'idconceptosombrero';    
    public $incrementing = true;
  
    protected $fillable = [ 
        'idconceptosombrero',
        'conceptosombrero',
        
    ];
    protected $attributes = [
        'idconceptosombrero' => false,
    ];
    public function getSombrero()
    {
        return $this->hasMany(Ofe_sombrero::class,'idconceptosombrero','idconceptosombrero');
    }
}