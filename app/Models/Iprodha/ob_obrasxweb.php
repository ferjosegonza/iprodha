<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ob_obrasxweb extends Model{

        use HasFactory;
        public $timestamps=false;        

        protected $table='iprodha.ob_obrasxweb';

        protected $primaryKey='ID_OBR';

        public $incrementing=false;

        protected $fillable=['ID_OBR','FECHACARGA','CUPO','FOJA'];
    }