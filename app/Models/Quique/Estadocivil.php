<?php

namespace App\Models\Quique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estadocivil extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'quique.estadocivil';
    protected $primaryKey = 'id_estciv';
    public $incrementing = false;

    protected $fillable = [ 
        'id_estciv',    'id_estciv',
        'desestciv',   'desestciv'
    ];
}
