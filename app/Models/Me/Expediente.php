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
        'exp_doc_id',
        'exp_numero',
        'exp_iniciante_apellido',
        'exp_iniciante_nombre',
        'exp_documento',
        'exp_asunto',
        'exp_par_tipo'

    ];
    protected $attributes = [
        'EXP_DOC_ID' => false,
    ];
    /**
     * Get the user that owns the Expediente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     
    public function getObra()
    {
        return $this->belongsTo(Ofe_obra::class, 'idexpediente', 'exp_doc_id');
    }

    // public function getExpNumeroWithoutSpaces() {
    //     return preg_replace('/\s+/', '', $this->exp_numero);
    // }
}
