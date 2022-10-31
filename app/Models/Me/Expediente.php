<?php

namespace App\Models\ME;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'ME.EXPEDIENTES';
    protected $primaryKey = 'exp_doc_id';
    public $incrementing = true;

    protected $fillable = [ 
        'EXP_DOC_ID',
        'EXP_NUMERO',
        'EXP_INICIANTE_APELLIDO',
        'EXP_INICIANTE_NOMBRE',
        'EXP_DOCUMENTO',
        'EXP_ASUNTO',
        'EXP_PAR_TIPO'
    ];
    protected $attributes = [
        'EXP_DOC_ID' => false,
    ];
    public function ExpedienteOfeObras()
    {
        return $this->hasOne(Ofe_obra::class,'exp_doc_id','idexpediente');
    }
}
