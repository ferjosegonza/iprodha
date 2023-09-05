<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iprodha\Ofe_subitem;

class Ofe_tipo_anticipo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'iprodha.ofe_tipo_anticipo';
   
    protected $primaryKey = 'id_tipo_anticipo'; 

    public $incrementing = true;
  
    protected $fillable = [ 
        'id_tipo_anticipo',
        'descripcion',
        'nom_tipo_anticipo'
    ];

    public function getOfeObras()
    {
        return $this->hasMany(Ofe_obra::class,'id_tipo_anticipo','id_tipo_anticipo');
    }
}
