<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sistemas_trigger_act extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.sistemas_trigger_act';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'id',
        'origen_esquema',
        'origen_tabla',
        'log_esquema',
        'log_tabla',
        'creacion',
    ];
    
    public function getDetalle()
    {
        return $this->hasOne(Sistemas_trigger_det::class, 'id_trigger_act', 'id');
    }
}