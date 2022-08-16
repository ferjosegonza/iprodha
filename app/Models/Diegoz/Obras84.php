<?php

namespace App\Models\Diegoz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estadocivil extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'diegoz.ob_obra84';
    protected $primaryKey = 'id_obra';
    public $incrementing = true;

    protected $fillable = [ 
        'nom_obr',    
        'expedte',
            ];
}
