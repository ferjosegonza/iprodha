<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncias extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'personal.PV_DENUNCIA';
    protected $primaryKey = 'id_denuncia';
    public $incrementing = false;
    protected $fillable = [
        'id_denuncia',
        'fecha',
        'extracto',
        'descripcion'
    ];

    public function denunciante(){
        return $this->hasOne(Denunciante::class, 'id_denuncia', 'id_denuncia');
    }

}
