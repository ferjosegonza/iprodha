<?php
namespace App\Models\Sol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sector extends Model{
    
    use HasFactory;

    public $timestamps = false; //para que es esto?

    protected $table = 'malazottos.sector';
    protected $primaryKey = 'id_sector';
    public $incrementing = false; //para que es esto?

    

    protected $fillable = [
        'id_sector', //ver
        'nom_sector',  'desc_sector'
    ];

    protected $maps = [ //esto para que se usa?
        'nom_sector' => 'nombre'
    ];
}