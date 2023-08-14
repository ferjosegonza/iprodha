<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_funcionario extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_FUNCIONARIO';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'id_tramite', 'id_funcionario_tipo', 'observacion'
    ];

    public function crear($id, $fun, $obs){
        $this->id_tramite = $id;
        $this->id_funcionario_tipo = $fun;
        $this->observacion = $obs;
        return $this->save();
    }
}