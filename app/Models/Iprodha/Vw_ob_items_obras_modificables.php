<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Vw_ob_items_obras_modificables extends Model{

        // protected $connection = 'oracleuser';

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.vw_ob_items_obras_modificables';

        //protected $primaryKey = 'id_obr';

        public $incrementing = false;

        protected $fillable=[
            'id_obr',
            'id_item',
            'orden',
            'nom_item',
            'costo',
        ];
    }