<?php
    namespace App\Models\Diegoz;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use App\Models\System\areas;
    use App\Models\Diegoz\users;
    class users_x_areas extends Model{
        use HasFactory;
        public$timestamps=false;    
        protected$table='diegoz.users_x_areas';                
        protected$fillable=['ID','CODARE'];
        public function areas(){return$this->hasOne(areas::class,'codare','codare');}
        public function users(){return$this->hasOne(users::class,'id','id');}
    }