<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ME\Expediente;

class vw_ofe_obras extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.vw_ofe_obras';
    //protected $primaryKey = 'idobra';
    //public $incrementing = true;
  
    protected $fillable = [ 
        'exp_doc_id',
        'idobra',
        'nomobra',
        'tipocontratofer',
        'exp_numero',
        'exp_asunto',
        'nom_emp',
        'nom_loc',
        
    ];
    protected $attributes = [
        'idobra'=> true,
        'nomobra'=> true,
        'tipocontratofer'=> true,
        'exp_numero'=> true,
        'exp_asunto'=> true,
        'nom_emp'=> true,
        'nom_loc'=> true,
        'exp_doc_id'=> true,
        
    ];


    public function scopeFiltronombre($query,$nomobra)
    {
        if ($nomobra == '' ) {
            return $query;  
        } else {
            return $query->where('nomobra', 'like', '%' .  strtoupper($nomobra) . '%'); 
        }          
    }
    public function getexpediente()
    {
        return $this->hasOne(Expediente::class,'exp_doc_id','exp_doc_id');
    }
   /*public function OfeObrasExpediente()
    {
        return $this->hasOne(MeExpedientes::class,'idexpediente','exp_doc_id');
    }
    public function OfeObrasLocalidad()
    {
        return $this->belongsTo(Localidad::class,'idloc','id_loc');
    }
    public function OfeObrasEmpresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa','id_emp');
    }*/
   /* public function OfeObrasTipoOferta()
    {
        return $this->belongsTo(Ofe_tipocontratoferta::class,'idtipocontratofer','IDTIPOCONTRATOFER');
    }*/
}