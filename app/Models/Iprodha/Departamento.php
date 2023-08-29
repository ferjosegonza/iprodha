<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Departamento extends Model{

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.departamento';

        protected $primaryKey = 'id_dep';

        public $incrementing = false;

        protected $fillable=[
            'id_dep',
            'nom_dep'
        ];

        public function getMunicipios()
        {
            return $this->hasMany(Municipios::class, 'id_departamento', 'id_dep');
        }
    }