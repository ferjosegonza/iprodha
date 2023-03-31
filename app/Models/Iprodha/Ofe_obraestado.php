<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofe_obraestado extends Model
{
    use HasFactory; 

    public $timestamps = false;   

    protected $table = 'iprodha.ofe_obraestado';
    protected $primaryKey = 'idestado';

    public $incrementing = true;
  
    protected $fillable = [ 
        'denestado',        
    ];

    public function getObras()
    {
        return $this->hasMany(Ofe_estadoxobra::class,'idestado','idestado');
        // return $this->belongsTo(Ofe_estadoxobra::class,'idestado','idestado');
    }
}