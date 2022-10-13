<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;

class Alumno extends Model implements Auditable
{
    use HasFactory;

    
    use \OwenIt\Auditing\Auditable;


    public $timestamps = false;
    
    protected $table = 'iprodha.alumno';
    protected $primaryKey = 'dni';
    public $incrementing = false;

    protected $fillable = [ 
        'dni',
        'nombre',
        'cuil',
        'fechanac'
    ];



    public function scopeNombre($query,$nombre)
    {
        if ($nombre == '') {
            return $query;
        } else {
            return $query->where('nombre','like','%'.$nombre.'%'); 
        }          
    }


    
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

}
