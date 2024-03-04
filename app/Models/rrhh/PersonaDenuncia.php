<?php
namespace App\Models\rrhh;


//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class PersonaDenuncia extends Model
{
  //  use HasFactory;

    public function sexo() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->hasOne(Sexo::class, 'codsexo', 'id_sexo');
    }
    public function tipoDni() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->hasOne(Tipdoc::class, 'id_tipdoc', 'tipo_doc');
    }
    public function vinculo() {
        //return $this->belongsTo(Sexo::class, 'codsexo', 'id_sexo');
        return $this->hasOne(Vinculo::class, 'id_vinculo', 'vinculo_inst');
    }
}
