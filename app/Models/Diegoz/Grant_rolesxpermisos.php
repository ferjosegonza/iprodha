<?php

namespace App\Models\Diegoz;
use Illuminate\Database\Eloquent\Model;

class Grant_rolesxpermisos extends Model
{
    
    protected $table = 'diegoz.grant_rolesxpermisos';
    public $timestamps = false;

    
    protected $fillable = [ 
        'permission_id',    'role_id'
    ];
    
    protected $primaryKey = 'permission_id';
    public $incrementing = false;
    
}
