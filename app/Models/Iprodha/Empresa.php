<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.empresa';
    protected $primaryKey = 'idid_empconcepto';
    public $incrementing = false;

    protected $fillable = [ 
        'id_emp','nom_emp'
     ];
    
}
