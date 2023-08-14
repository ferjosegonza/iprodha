<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_escribano extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_ESCRIBANO';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'id_tramite', 'matricula'
    ];

    public function crear($id, $mat){
        $this->id_tramite = $id;
        $this->matricula = $mat;
        return $this->save();
    }
}