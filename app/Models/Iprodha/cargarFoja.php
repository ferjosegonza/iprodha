<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class cargarFoja extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.vw_ob_paracargafoja';
        protected$primaryKey='id_obr';
        public$incrementing=true;
        protected$fillable=[ 
            'ID_OBR','NUM_OBR','NOM_OBR','NOM_EMP','NOM_LOC','ORDEN','ID_ITEM','ID_RED','NOM_ITEM','COSTO_CON',
            'ID_FOJA','NRO_FOJA','PERIODO_O','POR_ANT_OBR','POR_MES_OBR','POR_ANT_AVC','POR_MES_AVC','ID_INSPECTOR'
        ];        
    }