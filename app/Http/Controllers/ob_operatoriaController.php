<?php
    namespace App\Http\Controllers;
    use App\Models\Iprodha\ob_operatoria;
    class ob_operatoriaController extends Controller{
        public function index(){
            $ob_operatorias=ob_operatoria::all();
            return view('gabriel',compact('ob_operatorias'));
        }
        /*public function create(){return view("ob_operatoria.create");}
        public function store(Request $request){}
        public function show(Nivel $nivel){}
        public function edit(Nivel $nivel){}
        public function update(Request $request, Nivel $nivel){}
        public function destroy(Nivel $nivel){}*/
    }