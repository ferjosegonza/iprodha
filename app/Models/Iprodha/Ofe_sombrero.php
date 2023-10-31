<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofe_sombrero extends Model
{
    use HasFactory;
    protected $table = 'IPRODHA.OFE_SOMBRERO';
    protected $primaryKey = ['idobra','idconceptosombrero'];
    public $incrementing =false;
    public $timestamps = false;
    
    protected $fillable = [ 
        'idconceptosombrero',
        'idobra',
        'valor',
        
    ];
    protected $attributes = [
        'idconceptosombrero' => false,
        'idobra' => false,
        'valor' => false,
    ];


    public function getConceptoSombrero()
    {
        return $this->belongsTo(Ofe_conceptosombrero::class,'idconceptosombrero','idconceptosombrero');
    }
    
    public function getObra()
    {
        return $this->belongsTo(Ofe_obra::class,'idobra','idobra');
    }
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('idobra', '=', $this->getAttribute('idobra'))
            ->where('idconceptosombrero', '=', $this->getAttribute('idconceptosombrero'));

        return $query;
    }
    public function getFormattedValorAttribute()
    {
        return number_format($this->attributes['valor'], 2);
    }
    
}
