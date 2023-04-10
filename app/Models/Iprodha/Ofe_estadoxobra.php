<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofe_estadoxobra extends Model
{
    use HasFactory; 

    public $timestamps = false;   

    protected $table = 'iprodha.ofe_estadoxobra';
    protected $primaryKey = ['idobra', 'idestado', 'fechacambio'];
    
    public $incrementing = false;
  
    protected $fillable = [ 
        'idobra',
        'idestado',
        'fechacambio',
        'actual'        
    ];

    public function getEstado()
    {
        return $this->belongsTo(Ofe_obraestado::class,'idestado','idestado');
        // return $this->hasMany(Ofe_obraestado::class,'idestado','idestado');
    }

    public function getObra()
    {
        return $this->belongsTo(Ofe_obra::class, 'idobra', 'idobra');
    }

    protected function setKeysForSaveQuery($query)
     {
         $query
             ->where('idobra', '=', $this->getAttribute('idobra'))
             ->where('idestado', '=', $this->getAttribute('idestado'))
             ->where('fechacambio', '=', $this->getAttribute('fechacambio'));
         return $query;
    }
}