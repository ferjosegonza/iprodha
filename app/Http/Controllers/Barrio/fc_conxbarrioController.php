<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\fc_conxbarrio;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;    
    class fc_conxbarrioController extends Controller{
        public function index($unBarrio){
            $Barrio=Barrio::select('barrio','nombarrio')->where('barrio',$unBarrio)->get();
            $fc_conxbarrio=fc_conxbarrio::select('nomconcepto','valor')->where('barrio',$unBarrio)->get();
            return view('barrio.fc_conxbarrio',compact('Barrio','fc_conxbarrio'));
        }
    }