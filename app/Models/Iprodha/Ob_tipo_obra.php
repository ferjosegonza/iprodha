<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_tipo_obra extends Model{

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_tipo_obra';

        protected $primaryKey = 'id_tipo_obra';

        public $incrementing = false;

        protected $fillable = [
            'id_tipo_obra',
            'nom_tipo_obra',
            'abr_tipo_obra'
        ];

    }