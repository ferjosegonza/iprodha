<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class fc_parametros_uvi extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.fc_parametros_uvi';
        protected$primaryKey=['IDCONCEPTO'];
        public$incrementing=false;
        protected$fillable=['IDCONCEPTO','MONPOR','VALOR','NROFILA','NROCOLUMNA','CONCEPTO','SUMAORESTA'];        
    }