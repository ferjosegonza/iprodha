<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ob_tip_obr extends Model{

        use HasFactory;

        public $timestamps = false;        

        protected $table = 'iprodha.ob_tip_obr';

        protected $primaryKey = 'id_tip_obr';

        public $incrementing = false;

        protected $fillable = [
            'id_tip_obr',
            'tipo_obra',
        ];

        public function getObras(){
            return $this->hasMany(Ob_obra::class, 'id_tip_obr', 'id_tip_obr');
        }
    }