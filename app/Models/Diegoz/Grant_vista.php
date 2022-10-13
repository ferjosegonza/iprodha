<?php

namespace App\Models\Diegoz;
use Illuminate\Database\Eloquent\Model;

class Grant_vista extends Model
{
    
    protected $table = 'diegoz.Grant_vista';
    public $timestamps = true;
    protected $fillable = [ 
        'idvista',    'nomvista',
        'path',    'nomarchivo',
        'rol'
    ];    
    protected $primaryKey = 'idvista';
    public $incrementing = false;
    
}
