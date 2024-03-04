<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\rrhh\PersonaDenuncia;

class Victima extends PersonaDenuncia
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'personal.PV_VICTIMA';
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
        'VINCULO_INST'
    ];
}
