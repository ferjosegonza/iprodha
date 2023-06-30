<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_vivienda extends Model{

        protected $connection = 'oracleuser';
        
        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_vivienda';

        protected $primaryKey = 'id_viv';

        public $incrementing = true;

        protected $fillable = [
            'id_viv',
            'id_mun',
            'seccion',
            'chacra',
            'manzana',
            'parcela',
            'man_emp',
            'lot_emp',
            'finca',
            'partida',
            'plano',
            'id_ent',
            'edificio',
            'piso',
            'departamento',
            'escalera',
            'id_tip',
            'num_cal',
            'nom_cal',
            'cod_bar',
            'num_adj',
            'sup_lot',
            'fec_ter',
            'id_est_viv',
            'operatoria',
            'uni_fun',
            'sup_fin',
            'deslinde',
            'id_loc',
            'orden',
            'discap',
            'lote',
            'partida_2',
            'longitud',
            'latitud',
            'entrecalles',
        ];

        public function getEntrega()
        {
            return $this->belongsTo(Ob_entrega::class,'id_ent','id_ent');
        }
    }