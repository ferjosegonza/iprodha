<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class fc_tipologia extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.fc_tipologia';
        protected$primaryKey=['IDTIPOLOGIA'];
        public$incrementing=false;
        protected$fillable=[
            'IDTIPOLOGIA','ID_BENEFICIOSUBTIPO','ACTIVO','VE_RURALES','VE_EMERGENCIA',
            'VE_PROGRESIVA','TIPO_VISTO','TIPOLOGIA','PORCENTAJEAH','VE_OBRA'
        ];
    }