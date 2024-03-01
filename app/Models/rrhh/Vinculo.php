<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'iprodha.PV_VINCULO';
    protected $primaryKey = 'id_vinculo';
    public $incrementing = false;
    protected $fillable = [
        'id_vinculo',
        'descripcion'
    ];
}
