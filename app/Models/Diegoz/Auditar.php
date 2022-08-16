<?php


namespace App\Models\Diegoz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Auditar extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'diegoz.audits';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'ID',    'USER_TYPE',
        'USER_ID', 'EVENT',
        'AUDITABLE_TYPE',    'AUDITABLE_ID',
        'OLD_VALUES', 'NEW_VALUES',
        'URL',    'IP_ADDRESS',
        'USER_AGENT', 'TAGS',
        'CREATED_AT',    'UPDATED_AT'
    ];
    
}
