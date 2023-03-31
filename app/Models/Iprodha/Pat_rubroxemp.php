<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pat_rubroxemp extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.PAT_RUBROXEMP';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'id',    
        'id_emp',
        'id_rubro',
        'fecha'
    ];
}