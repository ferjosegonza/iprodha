<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_item_costo extends Model{

        // protected $connection = 'oracleuser';
        
        use HasFactory;

        public $timestamps=false;        

        protected $table = 'iprodha.ob_item_costo';

        protected $primaryKey = ['id_obr', 'id_item', 'id_red'];

        public $incrementing = false;

        protected $fillable=[
            'id_obr',
            'id_item',
            'id_red',
            'costo',
            'por_inc',
            'por_inv',
            'coef_var',
            'costo_con',
            'costo_red'
        ];
    }