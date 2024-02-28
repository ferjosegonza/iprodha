<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denunciante extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'personal.PV_DENUNCIANTE';
    protected $primaryKey = 'id_denuncia';
    public $incrementing = false;
    protected $fillable = [
        'ID_DENUNCIA',
        'NRO_DOC',
        'APELLIDO',
        'NOMBRE',
        'TIPO_DOC',
        'ID_SEXO',
        'FECHA_NAC',
        'DOMICILIO',
        'MAIL',
        'TELEFONO',
        'VINCULO_INST',
        'ES_VICTIMA'
    ];
}
