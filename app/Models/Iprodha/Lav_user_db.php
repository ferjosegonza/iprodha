<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lav_user_db extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.lav_user_db';

    protected $primaryKey = 'id_user_lav';
    
    public $incrementing = false;

    protected $fillable = [ 
        'id_user_lav',
        'user_lav',
        'pass_lav'
    ];

}