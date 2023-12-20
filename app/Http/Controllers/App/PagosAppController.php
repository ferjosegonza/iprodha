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
use PlusPagos\SHA256Encript;
use PlusPagos\AESEncrypter;

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
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $query = "SELECT sum(USUA400.FUN_MORA_CTA('$request->operatoria',CODBAR,NROADJ,NROCTA)
                + IMPORTEWEB) IMPORTETOTAL
                FROM iprodhaweb.cuotas_$request->operatoria
                WHERE codbar=$request->nro_barrio and nroadj=$request->nro_adju and NROCTA in($request->cuotas)";
        $importeTotal = DB::select( DB::raw($query));
        $pago = new Pol_pagoonlinecab;
        $id = $pago->guardar($importeTotal, 1, $request->operatoria, $request->nro_barrio, $request->nro_adju);
        if($id != -1){
            $query = "SELECT nrocta, USUA400.FUN_MORA_CTA('$request->operatoria', CODBAR, NROADJ, NROCTA)
                    + IMPORTEWEB IMPORTE FROM iprodhaweb.cuotas_$request->operatoria
                    WHERE codbar=$request->nro_barrio and nroadj=$request->nro_adju and nrocta in($request->cuotas)";
            $reg = DB::select( DB::raw($query));
            for($i=0;$i<count($reg);$i++){
                $detalle = new Pol_pagoonlinedet;
                $res = $detalle->guardar($id, 1, $reg[$i]->nrocta, $reg[$i]->importe);
                if(!$res){
                    return 0;
                }
            }
            return $id;
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
        $ipAddress = getRealIpAddr();
        $secretKey = 'IPRODHA_08692b3d-f495-4888-8a58-f254529fe2b1';
        $comercio = 'fe1d2911-f9f2-4046-871b-a5b3f713d812';
        $sucursal = ''; //enviar vac�o si no se tiene una sucursal configurada en PlusPagos
        $amount = $request->importe;
        $unHash = $hash->Generate($ipAddress, $secretKey, $comercio, $sucursal, $amount);
        $callbackSuccess = $row['CALLBACKSUCCESS'];
        $callbackCancel = $row['CALLBACKCANCEL'];
        $sucursalComercio = '';        
        $pro1;
        if (is_null($row['IDBPE'])){
            $pro1 = $row['PRODUCTO'];
        }else{
            $pro1 = $row['PRODUCTOBPE'];
        }

        // Sample data to send in the POST request
        $postData = [
            'CallbackSuccess' => $aes->EncryptString($callbackSuccess, $secretKey),
            'CallbackCancel' => $aes->EncryptString($callbackCancel, $secretKey),
            'Comercio' => $comercio,
            'SucursalComercio' => $aes->EncryptString($sucursalComercio, $secretKey),
            'Hash' => $unHash,
            'TransaccionComercioId' => $row['TRANSACCIONCOMERCIOID'],
            'Monto' => $aes->EncryptString($amount, $secretKey),
            'Producto[0]' => $row['PRODUCTO_0'],
            'Producto[1]' => $pro1,
            'Informacion' => $aes->EncryptString($row['INFORMACION'], $secretKey),
            'ClientData.CUIT' => $row['CLIENTDATA_CUIT'],
            'ClientData.NombreApellido' => $row['CLIENTDATA_NOMBREAPELLIDO']
        ];

        // Set the URL for the POST request
        $url = 'https://botonpp.asjservicios.com.ar/';

        // Make the POST request
        $response = Http::post($url, $postData);

        // Get the response body as an array or JSON
        $data = $response->json();

        // Process the response
        var_dump($data);
    }
}