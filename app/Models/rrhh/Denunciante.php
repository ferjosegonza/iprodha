<?php
namespace App\Models\rrhh;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\rrhh\Sexo;
// use App\Models\rrhh\TipoDni;
// use App\Models\rrhh\Vinculo;

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
        return $this->hasOne(Sexo::class, 'codsexo', 'id_sexo');
    }
    public function tipo_dni() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->hasOne(Tipo_dni::class, 'id_tipdoc', 'tipo_doc');
    }
    public function vinculo_inst() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->hasOne(Vinculo::class, 'id_vinculo', 'vinculo_inst');
    }
}
