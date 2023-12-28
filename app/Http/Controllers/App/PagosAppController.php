<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\Pol_pagoonlinecab;
use App\Models\Iprodha\Pol_pagoonlinedet;
use DB;

class PagosAppController extends Controller
{
    public function pagoBoleta(){
        return view('app.pagoBoleta');
    }

    public function grabarPagoOnline(Request $request){
        $validator = Validator::make($request->all(), [
            'operatoria' => 'required',
            'nro_adju' => 'required',
            'nro_barrio' => 'required',
            'cuotas' => 'required'
        ]);
        //return $request;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $query = "SELECT sum(a_pagar) IMPORTETOTAL from iprodha.vw_ahcrpi_adeuda d
        where d.ope = '$request->operatoria' and d.barrio = $request->nro_barrio
        and d.adju = $request->nro_adju and d.Cuota in ($request->cuotas)";
        $importeTotal = DB::select( DB::raw($query));
        $pago = new Pol_pagoonlinecab;
        $id = $pago->guardar($importeTotal[0]->importetotal, 1, $request->operatoria, $request->nro_barrio, $request->nro_adju);
        if($id != -1){
            $query = "SELECT * from iprodha.vw_ahcrpi_adeuda
                    WHERE barrio=$request->nro_barrio and adju=$request->nro_adju and cuota in($request->cuotas)";
            $reg = DB::select(DB::raw($query));
            for($i=0;$i<count($reg);$i++){
                $detalle = new Pol_pagoonlinedet;
                $res = $detalle->guardar($id, 1, $reg[$i]->cuota, $reg[$i]->a_pagar);
                if(!$res){
                    return 0;
                }
            }
            return response()->json($id);
        }
        else{
            return 0;
        }
    }

    public function irMacroClick(Request $request){
        $query = "SELECT * from IPRODHA.vw_pol_pagoonline
                  where transaccioncomercioid= $request->id";
        $row = DB::select( DB::raw($query));
        $comercio = 'ca309049-84d7-430a-af3a-ce747f3c1f50';
        $query = "SELECT * from IPRODHA.pol_pagoonlinecab c
        inner join iprodha.pol_pagoonlinedet d on c.idpagoonline=d.idpagoonline
        where c.idpagoonline= $request->id order by d.nrocomprobante desc";
        $importeTotal = DB::select( DB::raw($query));
        $amount = intval($importeTotal[0]->importetotal * 100);
        $callbackSuccess = $row[0]->callbacksuccess;
        $callbackCancel = $row[0]->callbackcancel;
        $pro1;
        if ($row[0]->idbpe == null){
            $pro1 = $row[0]->producto;
        }else{
            $pro1 = $row[0]->productobpe;
        }
        $info;
        if($row[0]->informacion == null){
            $info = '';
        }
        else{
            $info = $row[0]->informacion;
        }
        // Sample data to send in the POST request
        $postData = [
            'CallbackSuccess' => $callbackSuccess,
            'CallbackCancel' => $callbackCancel,
            'Comercio' => $comercio,
            'TransaccionComercioId' => $row[0]->transaccioncomercioid,
            'Monto' => $amount,
            'Producto[0]' => $row[0]->producto_0,
            'Producto[1]' => $pro1,
            'Informacion' => $info,
            'ClientData.CUIT' => $row[0]->clientdata_cuit,
            'ClientData.NombreApellido' => $row[0]->clientdata_nombreapellido
        ];

        return view('app.pagoBoleta')
        ->with('postData', $postData);
    }
}