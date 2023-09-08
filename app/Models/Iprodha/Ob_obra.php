<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_obra extends Model{

        protected $connection = 'oracleuser';

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_obra';

        protected $primaryKey = 'id_obr';

        public $incrementing = true;

        protected $fillable=[
            'id_obr',
            'nom_obr',
            'expedte',
            'id_emp',
            'id_loc',
            'mon_viv',
            'mon_inf',
            'mon_nex',
            'mon_ter',
            'fec_ini',
            'fec_ter',
            'plazo',
            'res_apr',
            'por_fle',
            'por_gas',
            'por_uti',
            'por_iva_viv',
            'por_iva_inf',
            'id_est_obr',
            'num_lic',
            'urbaniza',
            'id_ope',
            'alias',
            'mon_tope',
            'num_obr',
            'id_tip_obr',
            'nro_orden',
            'por_prov',
            'fec_cotiz',
            'mon_nac',
            'por_nac',
            'sub_tot1_viv',
            'sub_tot1_inf',
            'flete_viv',
            'flete_inf',
            'sub_tot2_viv',
            'sub_tot2_inf',
            'gas_gral_viv',
            'gas_gral_inf',
            'sub_tot3_viv',
            'sub_tot3_inf',
            'util_viv',
            'util_inf',
            'sub_tot4_viv',
            'sub_tot4_inf',
            'iva_viv',
            'iva_inf',
            'tot_bas_viv',
            'tot_bas_inf',
            'total_obra',
            'cot_a',
            'id_ampliacion',
            'id_situacion',
            'cotizacion',
            'id_inspector',
            'can_viv',
            'id_itemisado',
            'id_tipo_obra',
            'base_viv',
            'base_inf',
            'base_nex',
            'num_obr1',
            'recepdef',
            'tipoanticipo',
            'terr_retgan',
            'idobraas400',
            'deduc_sobrebasico',
            'num_tri',
            'mc_idobra',
            'coeficiente_mv',
            'sub_tot1_1',
            'uvi_cot'
        ];

        public function getEmpresa()
        {
            return $this->belongsTo(Empresa::class,'id_emp','id_emp');
        }

        public function getLocalidad(){
            return $this->belongsTo(Localidad::class, 'id_loc', 'id_loc');
        }

        public function getEtapas(){
            return $this->hasMany(Ob_etapa::class, 'id_obr', 'id_obr');
        }

        public function getOperatoria(){
            return $this->belongsTo(ob_operatoria::class,'id_ope','id_ope');
        }
    }