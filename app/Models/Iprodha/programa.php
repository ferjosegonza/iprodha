<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class programa extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.programa';
        protected$primaryKey=['ID_PROGRAMA'];
        public$incrementing=false;
        protected$fillable=['ID_PROGRAMA','DESCRIPCION'];        
    }