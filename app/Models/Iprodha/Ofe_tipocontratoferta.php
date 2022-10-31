<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ofe_tipocontratoferta extends Model
{
    use HasFactory;
    public $timestamps = false;
        
    protected $table = 'IPRODHA.OFE_TIPOCONTRATOFERTA';
    protected $primaryKey = 'IDTIPOCONTRATOFER';
    public $incrementing = true;
  
    protected $fillable = [ 
        'IDTIPOCONTRATOFER',
        'TIPOCONTRATOFER',
    ];
    protected $attributes = [
        'IDTIPOCONTRATOFER' => false,
        'TIPOCONTRATOFER'=> false,        
    ];
    public function ofetipocontratofertaObra()
    {
        return $this->hasMany(ofe_obra::class,'IDTIPOCONTRATOFER','IDTIPOCONTRATOFER');
    }
}
