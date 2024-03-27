<?php
    namespace App\Models\System;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class areas extends Model{
        use HasFactory;
        public$timestamps=false;    
        protected$table='system.areas';  
        protected$primaryKey='CODARE';              
        protected$fillable=['CODARE','DESARE','PREFIJO','INICIA_EXP','RECIBE_TD','NOMBRE_ANTERIRO','CODPADRE'];
    }