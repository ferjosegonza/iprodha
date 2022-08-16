<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Obras extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'IPRODHA.OB_OBRA';
    protected $primaryKey = 'id_obr';
    public $incrementing = true;

    protected $fillable = [ 
        'nom_obr',
        'expedte'
    ];
    protected $attributes = [
        'id_obra' => false,
    ];
    public function certificados()
    {
        return $this->hasMany(ObrasCertif::class,'id_obr','id_obra');
    }
    public function barrioxobra()
    {
        return $this->hasOne(Barrio::class,'id_obr','id_obr');
    }
}
