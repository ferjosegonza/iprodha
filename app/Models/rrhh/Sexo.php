<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'iprodha.SEXO';
    protected $primaryKey = 'codsexo';
    public $incrementing = false;
    protected $fillable = [
        'codsexo',
        'descsexo'
    ];
}
