<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncias extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'personal.PV_DENUNCIA';
    protected $primaryKey = 'ID_DENUNCIA';
    public $incrementing = false;
    protected $fillable = [
        'ID_DENUNCIA',
        'FECHA',
        'EXTRACTO',
        'DESCRIPCION'
    ];

}
