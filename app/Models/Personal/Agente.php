<?php

namespace App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Agente extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='PERSONAL.AGENTE';
    protected $primaryKey='idagente';
    protected $fillable=[ 
        'apellido', 'nombre','tipodoc', 'nrodoc', 'cuilt', 'fecnac', 'fecing', 'nacionalidad',
        'domicilio', 'domloc', 'codsexo', 'estciv', 'tratamiento', 'idubicfisica', 'idestudio',
        'idagrupamiento', 'nrocajaahorro', 'liquida', 'deposita','clave', 'antiganterior',
        'fecreconocido', 'calle', 'nrocalle', 'piso', 'departamento', 'email'
    ];        
}