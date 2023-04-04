<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Noc_Estado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.noc_estado';
    protected $primaryKey = ['idestado'];
    public $incrementing = false;

    protected $fillable = [ 
        'idestado', 'den_estado'
    ];
}