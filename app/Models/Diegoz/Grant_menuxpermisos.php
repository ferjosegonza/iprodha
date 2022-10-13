<?php

namespace App\Models\Diegoz;
use Illuminate\Database\Eloquent\Model;

class Grant_menuxpermisos extends Model
{
    
    protected $table = 'diegoz.grant_menuxpermisos';
    public $timestamps = false;

    
    protected $fillable = [ 
        'idpermiso',    'idmenu'
    ];
    
    protected $primaryKey = 'idpermiso';
    public $incrementing = false;
    
}
