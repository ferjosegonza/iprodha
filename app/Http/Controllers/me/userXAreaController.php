<?php
    namespace App\Http\Controllers\me;
    use App\Http\Controllers\Controller;
    use App\Models\Diegoz\users_x_areas;
    use App\Models\System\areas;
    use App\Models\Diegoz\users;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;
    class userXAreaController extends Controller{        
        public function index(){            
            $users=users::orderBy('email')->pluck('email','id');
            $areas=areas::orderBy('desare')->pluck('desare','codare');
            $users_x_areas=users_x_areas::with('users','areas')->get();            
            return view('me.userXArea',compact('users','areas','users_x_areas'));
        }
        public function store(Request $request){
            $users_x_areas=new users_x_areas;
            $users_x_areas->id=$request->input('id');
            $users_x_areas->codare=$request->input('codare');
            $users_x_areas->save();
            return redirect()->route('userXArea.index')->with('mensaje','Guardado con exito.');
        }
        public function destroy($id,$codare){
            $users_x_areas=users_x_areas::where('id',$id)->where('codare',$codare);
            $users_x_areas->delete();
            return redirect()->route('userXArea.index')->with('mensaje','borrado con éxito!.');
        }
    }