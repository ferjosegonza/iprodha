<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class ob_det_foja extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.ob_det_foja';
        protected$primaryKey=['id_foja','id_item'];
        public$incrementing=false;
        protected$fillable=[ 
            'ID_FOJA','ID_ITEM','MON_AVC','MON_OBR','POR_ACU_AVC',
            'POR_ACU_OBR','POR_ANT_AVC','POR_ANT_OBR','POR_MES_AVC','POR_MES_OBR'
        ];  
        protected function setKeysForSaveQuery($query){
            $query
            ->where('id_foja','=',$this->getAttribute('id_foja'))
            ->where('id_item','=',$this->getAttribute('id_item'));
            return $query;
        }     
    }