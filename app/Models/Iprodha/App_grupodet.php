<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_grupodet extends Model{

    use HasFactory;    
    public $timestamps=false;      
    protected $table = 'iprodha.app_grupodet';
    protected $primaryKey = ['id_grupo', 'id_usuario'];
    public $incrementing = false;
    
    protected $fillable = [ 
         'id_grupo', 'id_usuario'
    ];

    public function crear($grupo, $single){        
        $this->id_grupo = $grupo;
        $this->id_usuario = $single;
        return $this->save();
    }    

    protected function setKeysForSaveQuery($query)
    {
        return $query
            ->where('id_grupo', '=', $this->getAttribute('id_grupo'))
            ->where('id_usuario', '=', $this->getAttribute('id_usuario'));
    }
}