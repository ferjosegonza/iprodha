<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class ob_tipo_licitacion extends model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.ob_tipo_licitacion';
        protected$primaryKey='ID_TIPOLIC';
        public$incrementing=true;
        protected$fillable=['ID_TIPOLIC','DESCRIPCION'];
    }