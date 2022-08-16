<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ObrasCertif extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.OB_CERTIF_OBRA';
    protected $primaryKey = 'id_obra';
    public $incrementing = false;

    protected $fillable = [ 
        'NRO_CER_PAG',
        'NRO_CER_OBR',
        'ID_FOJA',
        'SUB_TOT1_VIV',
        'SUB_TOT1_INF'
        
    ];
    protected $attributes = [
        'ID_OBRA' => false,
    ];
    public function obras()
    {
        return $this->belongsTo(Obras::class,'id_obr','id_obra');
    }

}
