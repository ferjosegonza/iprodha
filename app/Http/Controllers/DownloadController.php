<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use DB;
 
class DownloadController extends Controller
{
    public function downloadfile($opt)
    {
        // return $url;
        switch ($opt) {
            case 'ofeobra':
                $filepath = public_path("storage/gdu/OfertaObraEmp.pdf");
                break;
            
            default:
                # code...
                break;
        }
        // $url = str_replace('#','/', $url);
        
        return Response::download($filepath); 
    }
}