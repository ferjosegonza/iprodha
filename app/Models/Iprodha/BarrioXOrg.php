<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class BarrioXOrg extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.barrioxorg';
        protected$primaryKey=['barrio','idorganismo'];
        public$incrementing=false;
        protected$fillable=['BARRIO','IDORGANISMO','IDTIPOFAC','CANDOR','IDTIPOTERRE','PLAZO'];
        protected function setKeysForSaveQuery($query){
            $query
            ->where('barrio','=',$this->getAttribute('barrio'))
            ->where('idorganismo','=',$this->getAttribute('idorganismo'));
            return$query;
        }     
    }