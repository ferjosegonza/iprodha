<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_etapa extends Model{

        use HasFactory;

        public $timestamps=false;        

        protected $table = 'iprodha.ob_etapa';

        protected $primaryKey = 'id_etapa';

        public $incrementing = false;

        protected $fillable=[
            'id_etapa',
            'id_obr',
            'nro_eta',
            'descripcion',
            'can_viv_2',
            'can_viv_3',
            'can_viv_4',
            'id_localidad'
        ];

        public function getLocalidad()
        {
            return $this->belongsTo(Localidad::class,'id_localidad','id_loc');
        }

        public function getObra(){
            return $this->belongsTo(Ob_obra::class, 'id_obr', 'id_obr');
        }

        public function getEntregas(){
            return $this->hasMany(Ob_entrega::class, 'id_eta','id_etapa');
        }
    }