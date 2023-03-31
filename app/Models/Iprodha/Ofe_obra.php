<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Ofe_item;

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
        'iduserweb',
    ];
    protected $attributes = [
        'idobra' => false,

    ];

    public function getMescotizacionAttribute() {
        return sprintf("%02d", $this->attributes['mescotizacion']);
    }

    public function getPublicaAttribute(){
        return date("Y-m-d", strtotime($this->attributes['publica']));
    }
    
    public function getExpediente()
    {
        return $this->hasOne(Expediente::class,'exp_doc_id','idexpediente');
    }
    public function getItems()
    {            
        return $this->hasMany(Ofe_item::class,'idobra','idobra');
    }
    public function getSombrero()
    {
        return $this->hasMany(Ofe_sombrero::class,'idobra','idobra');
    }
    public function getEmpresa()
    {
        return $this->belongsTo(Empresa::class,'idempresa','id_emp');
    }
    public function getLocalidad()
    {
        return $this->belongsTo(Localidad::class,'idloc','id_loc');
    }
    public function getmoninf()
    {
        return number_format($this->moninf, 2, ',', '.');
    }

    public function getEstados()
    {
        return $this->hasMany(Ofe_estadoxobra::class, 'idobra', 'idobra');
    }
    /*public function OfeObrasLocalidad()
    {
        return $this->belongsTo(Localidad::class,'idloc','id_loc');
    }
    public function OfeObrasEmpresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa','id_emp');
    }*/

    public function getTipoOferta()
    {
        return $this->belongsTo(Ofe_tipocontratoferta::class,'idtipocontratofer','IDTIPOCONTRATOFER');
    }
}