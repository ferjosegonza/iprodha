<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class ob_operatoria extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.ob_operatoria';
        protected$primaryKey='id_ope';
        public$incrementing=true;
        protected$fillable=[ 
            'OPERATORIA','ABR_OPE','DEN_INSC','VER_INSC','ID_OPEINSC','CERTIFICA',
            'ADMINISTRACION','CUENTA','BANCO','CARACTER','OPERAT_ADM','APICOFOM','VER_INSWEB'            
        ];        
    }