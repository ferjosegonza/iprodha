<?php
namespace App\Models\Sol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class p_Almacen extends Model{
    
    use HasFactory;

    public $timestamps = false; //para que es esto?

    protected $table = 'malazottos.pat_almacen';
    protected $primaryKey = 'id_almacen';
    public $incrementing = false; //para que es esto?

    

    protected $fillable = [
        'id_almacen', 'fk_sector',//ver
        'nom_almacen',  'abr_almacen',  'dom_almacen', 'imagen'
    ];

    protected $maps = [ //esto para que se usa?
        'nom_almacen' => 'nombre'
    ];

    
}