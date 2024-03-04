<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Pol_pagoonlinecab extends Model{
    use HasFactory;
    public $timestamps=false;
    protected $table='iprodha.pol_pagoonlinecab';
    protected $primaryKey='idpagoonline';
    public $incrementing = false;
    protected $fillable=[ 
        'idpagoonline', 'fechagen', 'importetotal', 'shasign', 'idorigenpago', 'operatoria', 'barrio', 'adju',
        'fechapago', 'fechacruce', 'importepagado', 'pasadoatxt', 'idbpe', 'estado_pasarela'
    ];

   
    public function guardar($importe, $origen, $op, $ba, $ad){
        $this->importetotal = $importe;
        $this->idorigenpago = $origen;
        $this->operatoria = $op;
        $this->barrio = $ba;
        $this->adju = $ad;
        $this->estado_pasarela=0;
        $query = 'SELECT IPRODHA.SEC_POL_TRANSACCION.nextval ID_PAG from dual';
        $id = DB::select( DB::raw($query));
        $this->idpagoonline= $id[0]->id_pag;
        if($this->save()){
            return $id[0]->id_pag;
        }
        else{
            return -1;
        }
    }

}