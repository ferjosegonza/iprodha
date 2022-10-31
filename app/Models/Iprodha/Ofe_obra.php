<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofe_obra extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.OFE_OBRA';
    protected $primaryKey = 'idobra';
    public $incrementing = true;
  
    protected $fillable = [ 
        'idobra',
        'nomobra',
        'idexpediente',
        'idempresa',
        'idloc',
        'monviv',
        'moninf',
        'monnex',
        'monterr',
        'plazo',
        'idtipocontratofer',
        'numofer',
        'montotope',
        'aniocotizacion',
        'mescotizacion',
        'publica', 
    ];
    /*protected $attributes = [
        'IDOBRA' => false,
        'NOMOBRA'=> false,
        'IDEXPEDIENTE'=> false,
        'IDEMPRESA'=> false,
        'IDLOC'=> false,
        'MONVIV'=> false,
        'MONINF'=> false,
        'MONNEX'=> false,
        'MONTERR'=> false,
        'PLAZO'=> false,
        'IDTIPOCONTRATOFER'=> false,
        'NUMOFER'=> false,
        'ANIOOFER'=> false,
        'MONTOTOPE'=> false,
        'ANIOCOTIZACION'=> false,
        'MESCOTIZACION'=> false,
        'PUBLICA'=> false,
        
    ];*/
   public function OfeObrasExpediente()
    {
        return $this->hasOne(MeExpedientes::class,'idexpediente','exp_doc_id');
    }
    /*public function OfeObrasLocalidad()
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