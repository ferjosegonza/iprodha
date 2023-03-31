<?php

namespace App\Models\Silverol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ob_foja_fotos extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.ob_foja_fotos';
    protected $primaryKey = ['ob_foja_fotos', 'nrofoto'];
    public $incrementing = false;

    protected $fillable = [ 
        'ob_foja_fotos', 'nrofoto', 
        'ubicacion', 'observacion'
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('ob_foja_fotos', '=', $this->getAttribute('ob_foja_fotos'))
            ->where('nrofoto', '=', $this->getAttribute('nrofoto'));
        return $query;
    }
}