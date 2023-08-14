<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_beneficiario extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_BENEFICIARIO';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'id_tramite', 'dni', 'ope', 'barrio', 'adju'
    ];

    public function crear($id, $dni, $ope, $bar, $adj){
        $this->id_tramite = $id;
        $this->dni = $dni;
        $this->ope = $ope;
        $this->barrio= $bar;
        $this->adju = $adj;
        return $this->save();
    }
}