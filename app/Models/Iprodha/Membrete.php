<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Membrete extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'iprodha.membrete';

    public $incrementing = false;

    protected $fillable = [
        'texto_1',
        'texto_2',
        'imagen_1',
        'imagen_2',
        'actual',
        'anterior',
        'texto_1_1',
        'texto_1_1_1',
        'presidente',
        'dnipresi',
        'texto_1_1_2',
    ];
}