<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos
use App\Models\Silverol\CategoriaLaboral;
use \PDF;


class CategorialaboralController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-CATEGORIALABORAL|CREAR-CATEGORIALABORAL|EDITAR-CATEGORIALABORAL|BORRAR-CATEGORIALABORAL', ['only' => ['index']]);
         $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {        
        $name = $request->query->get('name');
        if (!isset($name)) {
               
            //Con paginación
            $CategoriasLaborales = CategoriaLaboral::orderBy('id_catlaboral', 'asc')->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $CategoriasLaborales = CategoriaLaboral::whereRaw('UPPER(catlaboral) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('id_catlaboral', 'asc')->paginate(10);
        }

        return view('categorialaboral.index',compact('CategoriasLaborales'));
    }
    
    public function create(Request $request)
    {
        return view('categorialaboral.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
             'categoria' => 'required|string',
             'web' => 'required|boolean',
             'sumaingreso' => 'required|boolean',
             'datoslaborales' => 'required|min:0|max:3|integer',
        ]);

        $input = $request->all();

        $modelo = new CategoriaLaboral;

        $modelo->catlaboral = strtoupper($request->input('categoria'));
        $modelo->web = $request->input('web');
        $modelo->sumaingreso = $request->input('sumaingreso');
        $modelo->datolab = $request->input('datoslaborales');


               
        $data = CategoriaLaboral::latest('id_catlaboral')->first();
        $modelo->id_catlaboral = $data['id_catlaboral'] + 1;
        
        $data = CategoriaLaboral::where('catlaboral', $modelo->catlaboral)->first();
        
        if (isset($data['catlaboral'])) {
            return redirect()->route('categorialaboral.index')->with('alerta','¡Ya existe la categoria!');
        }
        
        $modelo->save();
        return redirect()->route('categorialaboral.index')->with('mensaje','La categoria laboral '.$modelo->catlaboral.' creado con exito.');                      
    }

    public function show($id)
    {
    }

   
    public function edit(Request $request, $id)
    {
        $CategoriaLaboral = CategoriaLaboral::findOrFail($id);
    
        return view('categorialaboral.editar',compact('CategoriaLaboral'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'categoria' => 'required|string',
            'web' => 'required|boolean',
            'sumaingreso' => 'required|boolean',
            'datoslaborales' => 'required|min:0|max:3|integer',
       ]);
    
        $modelo = CategoriaLaboral::find($id);
        $modelo->catlaboral = strtoupper($request->input('categoria'));
        $modelo->web = $request->input('web');
        $modelo->sumaingreso = $request->input('sumaingreso');
        $modelo->datolab = $request->input('datoslaborales');
        $modelo->save();
    
        return redirect()->route('categorialaboral.index')->with('mensaje',$request->input('categoria').' editado exitosamente.');                                          
    }

    public function destroy($id)
    {
        $categoria = CategoriaLaboral::findOrFail($id);
        $nombre = $categoria->catlaboral;
        CategoriaLaboral::destroy($id);
        return redirect()->route('categorialaboral.index')->with('mensaje','Categoria laboral '.$nombre.' borrado con éxito!.');     
        
    }

    public function pdf()
    {
        // alternativamente con:
        $pdf = app('dompdf.wrapper');
        
        $categorias = CategoriaLaboral::orderBy('id_catlaboral', 'asc')->paginate(10); 
        
        return $pdf->loadView('categorialaboral.pdf',['categorialaboral'=>$categorias])
                                    ->setPaper('a4', 'landscape')
                                    ->stream('categoriasLaborales.pdf');
    }
}
