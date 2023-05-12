<?php
    namespace App\Models\Iprodha;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    class Barrio extends Model{
        use HasFactory;
        public$timestamps=false;    
        protected$table='IPRODHA.BARRIO';
        protected$primaryKey='barrio';
        public$incrementing=true;
        protected$fillable=['ABRBARRIO','BARRIO','CANVIV','CUENTABCO','ENTREGA','ETAPA','FACTURA','FEC_ENTREGA','FECHA_ALTA',
            'ID_ENT','ID_LOC','ID_OBR','ID_PROGRAMA','IDTIPBARRIO','IDTIPOLOGIA','IDTIPOOBRA','IDZONA','MTSTERRE1',
            'MTSTERRE2','MTSTERRE3','MTS0','MTS1','MTS2','MTS3','MTS4','NOMBARRIO','NRO_OBRA','NRO_RES','OBS',
            'PORC_FACTURA','PORFIN','TIPOFINAN','TIPOPRECIO','UBICACION','VIEJO'
        ];
        protected$attributes=['barrio'=>false,];        
        public function barrioLocalidad(){return$this->belongsTo(Localidad::class,'id_loc','id_loc');}
        public function obraxbarrio(){return$this->hasOne(Obras::class,'id_obr','id_obr');}
    }