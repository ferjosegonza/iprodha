<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class ob_licitacion extends model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.ob_licitacion';
        protected$primaryKey='ID_LICITACION';
        public$incrementing=true;
        protected$fillable=['ID_LICITACION','NUMERO','PATH','ID_TIPO','APERTURA','DENOMINACION','AÑO'];
    }