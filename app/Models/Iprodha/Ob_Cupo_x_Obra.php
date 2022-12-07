<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ob_Cupo_x_Obra extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.ob_cupoxobra';
    protected $primaryKey = ['id_obr', 'anio', 'mes'];
    public $incrementing = false;

    protected $fillable = [ 
        'id_obr',    'anio',
        'mes',   'cupo',
        'fecha_carga'
    ];
    
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_obr', '=', $this->getAttribute('id_obr'))
            ->where('anio', '=', $this->getAttribute('anio'))
            ->where('mes', '=', $this->getAttribute('mes'));
        return $query;
    }
}