<?php    
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class fc_conxbarrio extends Model{
        use HasFactory;
        public$timestamps=false;        
        protected$table='iprodha.fc_conxbarrio';
        protected$primaryKey=['idtipofacr','idtipoterre'];
        public$incrementing=false;
        protected$fillable=[
            'IDTIPOFACR','IDTIPOTERRE','IDORGANISMO','NOMCONCEPTO','SUMAORESTA',
            'NROCOLUMNA','MONPOR','VALOR','CANDOR','BARRIO','IDCONCEPTO','NROFILA'
        ];
        protected function setKeysForSaveQuery($query){
            $query
            ->where('idtipofacr','=',$this->getAttribute('idtipofacr'))
            ->where('idtipoterre','=',$this->getAttribute('idtipoterre'));
            return$query;
        }     
    }