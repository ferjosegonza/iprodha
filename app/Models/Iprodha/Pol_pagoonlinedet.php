<?php

namespace App\Models\Iprodha;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Pol_pagoonlinedet extends Model{
    use HasFactory;
    public $timestamps=false;        
    protected $table='iprodha.pol_pagoonlinedet';
    protected $primaryKey='idpagoonline';
    public $incrementing = false;
    protected $fillable=[ 
        'idpagoonline', 'idtipopago', 'nrocomprobante', 'importecomprobante'
    ];

   
    public function guardar($id, $tipo, $nro, $imp){
        $this->idpagoonline= $id;
        $this->idtipopago = $tipo;
        $this->nrocomprobante = $nro;
        $this->importecomprobante = $imp;
        return $this->save();
    }
}