<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class tipobarrio extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.tipobarrio';
        protected$primaryKey=['IDTIPBARRIO'];
        public$incrementing=false;
        protected$fillable=['IDTIPBARRIO','DIAVTO','REGULARIZA','ORDEN','ABR_TIPOBARRIO','TIPOBARRIO','PERIODOFAC'];        
    }