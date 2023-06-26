<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Dba_users extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sys.dba_users';

    protected $primaryKey = ['user_id'];
    
    public $incrementing = false;

    protected $fillable = [ 
        'user_id',
        'user_name'
    ];

}