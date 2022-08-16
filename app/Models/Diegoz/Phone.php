<?php


namespace App\Models\Diegoz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Phone extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'phone';
    protected $primaryKey = 'idphone';
    public $incrementing = false;

    protected $fillable = [ 
        'idphone',    'name',
        'compania', 'idpersona'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'idpersona' ,'id');
    }
}
