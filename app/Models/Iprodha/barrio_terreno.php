<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class barrio_terreno extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.barrio_terreno';
        protected$primaryKey=['idtipoterre','barrio'];
        public$incrementing=false;
        protected$fillable=['BARRIO','SUPERFICIE','IDTIPOTERRE'];
        protected function setKeysForSaveQuery($query){
            $query
            ->where('barrio','=',$this->getAttribute('barrio'))
            ->where('idtipoterre','=',$this->getAttribute('idtipoterre'));
            return$query;
        }     
    }