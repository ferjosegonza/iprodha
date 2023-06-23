<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_entrega extends Model{

        protected $connection = 'oracleuser';
        
        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_entrega';

        protected $primaryKey = 'id_ent';

        public $incrementing = false;

        protected $fillable = [
            'id_ent',
            'id_eta',
            'num_ent',
            'descripcion',
            'fec_ent',
            'cant_viv'
        ];

        public function getEtapa()
        {
            return $this->belongsTo(Ob_etapa::class,'id_eta','id_etapa');
        }

        public function getViviendas()
        {
            return $this->hasMany(Ob_vivienda::class, 'id_ent', 'id_ent');
        }
    }