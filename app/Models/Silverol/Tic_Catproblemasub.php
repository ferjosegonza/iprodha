<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Catproblemasub extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'silverol.tic_catproblemasub';
    protected $primaryKey = 'idcatprobsub';
    public $incrementing = false;

    protected $fillable = [ 
        'idcatprobsub', 'idcatprob', 'catprobsub'
    ];
    
    public function getCatProblema()
    {
        return $this->belongsTo(Tic_Catproblema::class,'idcatprob','idcatprob');
    }

    public function getTicket()
    {
        return $this->hasMany(Tic_Tarea::class, 'idcatprobsub','idcatprobsub');
    }
}