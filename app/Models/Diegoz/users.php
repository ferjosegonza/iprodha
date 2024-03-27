<?php
    namespace App\Models\Diegoz;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class users extends Model{
        use HasFactory;
        public$timestamps=false;    
        protected$table='diegoz.users';  
        protected$primaryKey='ID';              
        protected$fillable=['ID','NAME','EMAIL','EMAIL_VERIFIED_AT','PASSWORD','REMEMBER_TOKEN','CREATED_AT','UPDATED_AT'];
    }