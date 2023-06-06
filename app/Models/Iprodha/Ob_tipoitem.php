<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_tipoitem extends Model{

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_tipoitem';

        protected $primaryKey = 'idtipoitem';

        public $incrementing = false;

        protected $fillable = [
            'idtipoitem',
            'dentipoitem',
        ];

    }