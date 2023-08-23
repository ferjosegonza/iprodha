<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_tramite_documento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.NOT_TRAMITE_DOCUMENTO';
    protected $primaryKey = 'id_tramite';

    protected $fillable = [ 
        'id_tramite', 'id_documento'
    ];

    public function crear($id, $doc){
        $this->id_tramite = $id;
        $this->id_documento = $doc;
        return $this->save();
    }
}