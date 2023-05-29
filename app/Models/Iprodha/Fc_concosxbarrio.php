<?php
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class Fc_concosxbarrio extends Model{
        use HasFactory;
        public$timestamps=false;
        protected$table='IPRODHA.fc_concosxbarrio';
        protected$primaryKey='BARRIO';
        public$incrementing=true;
        protected$fillable=['BARRIO','IDORGANISMO','CONCOSTO','SUMAORESTA','IMPORTE','ID_CONCOSTO','CANTDORM','IDTIPOFAC','IDTIPOTERRE'];
        protected $attributes=['barrio'=>false,];    
        public function Fc_concosxbarrio_costosxbarrio(){return $this->hasMany(Barrio::class,'barrio','barrio');}
        public function barrio_terreno(){return$this->belongsTo(barrio_terreno::class,'barrio_terreno.barrio','barrio_terreno.idtipoterre');}
    }