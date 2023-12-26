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
use App\Http\Controllers\App\SHA256Encript;
use App\Http\Controllers\App\AESEncrypter;

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
        $query = "SELECT sum(nvl(USUA400.FUN_MORA_CTA('$request->operatoria',CODBAR,NROADJ,NROCTA),0)
                + IMPORTEWEB) IMPORTETOTAL
                FROM iprodhaweb.cuotas_$request->operatoria
                WHERE codbar=$request->nro_barrio and nroadj=$request->nro_adju and NROCTA in($request->cuotas)";
        $importeTotal = DB::select( DB::raw($query));
        $pago = new Pol_pagoonlinecab;
        $id = $pago->guardar($importeTotal[0]->importetotal, 1, $request->operatoria, $request->nro_barrio, $request->nro_adju);
        if($id != -1){
            $query = "SELECT nrocta, nvl(USUA400.FUN_MORA_CTA('$request->operatoria', CODBAR, NROADJ, NROCTA),0)
                    + IMPORTEWEB IMPORTE FROM iprodhaweb.cuotas_$request->operatoria
                    WHERE codbar=$request->nro_barrio and nroadj=$request->nro_adju and nrocta in($request->cuotas)";
            $reg = DB::select(DB::raw($query));
            return $reg;
            for($i=0;$i<count($reg);$i++){
                $detalle = new Pol_pagoonlinedet;
                $res = $detalle->guardar($id, 1, $reg[$i]->nrocta, $reg[$i]->importe);
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
        $aes = new AESEncrypter();
        $query = "SELECT * from IPRODHA.vw_pol_pagoonline
                  where transaccioncomercioid= $request->id";
        $row = DB::select( DB::raw($query));
        $hash = new SHA256Encript();
        $ipAddress = $request->ip();
        $secretKey = 'IPRODHA_08692b3d-f495-4888-8a58-f254529fe2b1';
        $comercio = 'fe1d2911-f9f2-4046-871b-a5b3f713d812';
        $sucursal = '';
        $query = "SELECT * from IPRODHA.pol_pagoonlinecab c
        inner join iprodha.pol_pagoonlinedet d on c.idpagoonline=d.idpagoonline
        where c.idpagoonline= $request->id order by d.nrocomprobante desc";
        $importeTotal = DB::select( DB::raw($query));
        $amount = intval($importeTotal[0]->importetotal * 100);
        $unHash = $hash->Generate($ipAddress, $secretKey, $comercio, $sucursal, $amount);
        $callbackSuccess = $row[0]->callbacksuccess;
        $callbackCancel = $row[0]->callbackcancel;
        $sucursalComercio = '';
        $pro1;
        if ($row[0]->idbpe == null){
            $pro1 = $row[0]->producto;
        }else{
            $pro1 = $row[0]->productobpe;
        }
        // Sample data to send in the POST request
        $postData = [
            'CallbackSuccess' => $aes->EncryptString($callbackSuccess, $secretKey),
            'CallbackCancel' => $aes->EncryptString($callbackCancel, $secretKey),
            'Comercio' => $comercio,
            'SucursalComercio' => $aes->EncryptString($sucursalComercio, $secretKey),
            'Hash' => $unHash,
            'TransaccionComercioId' => $row[0]->transaccioncomercioid,
            'Monto' => $aes->EncryptString($amount, $secretKey),
            'Producto[0]' => $row[0]->producto_0,
            'Producto[1]' => $pro1,
            'Informacion' => $aes->EncryptString($row[0]->informacion, $secretKey),
            'ClientData.CUIT' => $row[0]->clientdata_cuit,
            'ClientData.NombreApellido' => $row[0]->clientdata_nombreapellido
        ];
        // Set the URL for the POST request
        $url = 'https://botonpp.asjservicios.com.ar/';

        // Make the POST request
        $response = Http::post($url, $postData);
        return $response;
        // Get the response body as an array or JSON
        $data = $response->json();

        // Process the response
        var_dump($data);
    }
}