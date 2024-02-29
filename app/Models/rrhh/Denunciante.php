<?php
namespace App\Models\rrhh;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rrhh\Sexo;

class Denunciante extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'personal.PV_DENUNCIANTE';
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
        'vinculo_inst',
        'es_victima'
    ];

    public function sexo() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->belongsTo(Sexo::class, 'id_sexo', 'codsexo');
    }
}
