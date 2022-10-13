<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Catproblema extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'silverol.tic_catproblema';
    protected $primaryKey = 'idcatprob';
    public $incrementing = false;

    protected $fillable = [ 
        'idcatprob',    'descatprob',
        'baja'
    ];

    // protected $dates = ['baja'];

    public function getCatProblemaSub()
    {
        return $this->hasMany(Tic_Catproblemasub::class,'idcatprob','idcatprob');
    }

    // function getBaja()
    // {
    //     return $this->attributes['baja']->format('d-m-Y');
    // }
}
