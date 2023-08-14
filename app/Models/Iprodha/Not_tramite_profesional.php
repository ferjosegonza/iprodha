<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_profesional extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_PROFESIONAL';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'id_tramite', 'id_profesional', 'id_caracter'
    ];

    public function crear($id, $prof, $car){
        $this->id_tramite = $id;
        $this->id_profesional = $prof;
        $this->id_caracter= $car;
        return $this->save();
    }

}