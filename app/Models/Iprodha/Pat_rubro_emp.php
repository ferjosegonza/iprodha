<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pat_rubro_emp extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.PAT_RUBRO_EMP';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [ 
        'id',    
        'rubro',
    ];
    
    public function getEmpresas()
    {
        return $this->belongsToMany(Empresa::class, 'iprodha.PAT_RUBROXEMP', 'id', 'id_emp');
    }
}