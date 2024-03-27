<?php
    namespace App\Models\Me;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class vw_bandeja_entrada extends Model{
        use HasFactory;
        public$timestamps=false;    
        protected$table='me.vw_bandeja_entrada';                
        protected$fillable=['DOC_ID','TIPO','NUMERO','ASUNTO','MOV_FECHA'];        
    }