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
        'id_denuncia',
        'nro_doc',
        'apellido',
        'nombre',
        'tipo_doc',
        'id_sexo',
        'fecha_nac',
        'domicilio',
        'mail',
        'telefono',
        'vinculo_inst'
    ];
}
