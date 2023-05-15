<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class BarrioXOrg extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.barrioxorg';
        protected$primaryKey=['barrio','candor','idtipoterre'];
        public$incrementing=false;
        protected$fillable=['BARRIO','IDORGANISMO','IDTIPOFAC','CANDOR','IDTIPOTERRE','PLAZO'];
        protected function setKeysForSaveQuery($query){
            $query
            ->where('barrio','=',$this->getAttribute('barrio'))
            ->where('candor','=',$this->getAttribute('candor'))
            ->where('idtipoterre','=',$this->getAttribute('idtipoterre'));
            return$query;
        }     
    }