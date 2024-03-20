<?php

namespace App\Http\Controllers\Sociales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Tur_cola;
use App\Models\Iprodha\Tur_tramite;
use App\Models\Iprodha\Tur_horarioxcola;
use App\Models\Iprodha\Tur_turno;
use Carbon\Carbon;
use DB;

class TurnosController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(){
        $query = "SELECT t.idcola as idcola, t.descripcion, t.publicado, t.fecha_desde, t.fecha_hasta, t.cant_puestos, 
        t.duracion_turno, tr.denominacion, sc1.turnos FROM iprodha.tur_cola t
        inner join iprodha.tur_tramite tr on tr.idtramite = t.idtramite
        inner join (select t.idcola as idcola, count(tu.idturno) as turnos FROM iprodha.tur_cola t
        left join iprodha.tur_turno tu on tu.idcola = t.idcola
        group by t.idcola) sc1 on sc1.idcola = t.idcola";
        $colas = DB::select( DB::raw($query));
        return view('Sociales.turnos')
        ->with('colas', $colas);
    }
    
    public function nueva_cola(){
        $tramites = Tur_tramite::get();
        return view('Sociales.nueva_cola')
        ->with('tramites', $tramites);
    }

    public function postCola(Request $request){
        $request->validate([
            'descripcion' => 'required',
            'puestos' => 'required|integer',
            'duracion' => 'required|integer',
            'desde' => 'required',
            'hasta' => 'required',
            'tramite' => 'required',
            'dias'  => 'required',
            'horarioLunes' => 'required',
            'horarioMartes' => 'required',
            'horarioMiercoles' => 'required',
            'horarioJueves'  => 'required',
            'horarioViernes' => 'required'
        ]);
        $cola = new Tur_cola;
        $res = 1;
        $res *= $cola->crear($request->descripcion, $request->desde, $request->hasta,
        $request->puestos, $request->duracion, $request->tramite);
        if($request->dias[0] == 'true'){
            $lunes= new Tur_horarioxcola;
            $res *= $lunes->crear($cola->idcola, 2, $request->horarioLunes['horaInicio'], 
            $request->horarioLunes['minInicio'], $request->horarioLunes['horaFin'], 
            $request->horarioLunes['minFin']);
        }
        if($request->dias[1] == 'true'){
            $martes= new Tur_horarioxcola;
            $res *= $martes->crear($cola->idcola, 3, $request->horarioMartes['horaInicio'], 
            $request->horarioMartes['minInicio'], $request->horarioMartes['horaFin'], 
            $request->horarioMartes['minFin']);
        }
        if($request->dias[2] == 'true'){
            $miercoles= new Tur_horarioxcola;
            $res *= $miercoles->crear($cola->idcola, 4, $request->horarioMiercoles['horaInicio'], 
            $request->horarioMiercoles['minInicio'], $request->horarioMiercoles['horaFin'], 
            $request->horarioMiercoles['minFin']);
        }
        if($request->dias[3] == 'true'){
            $jueves= new Tur_horarioxcola;
            $res *= $jueves->crear($cola->idcola, 5, $request->horarioJueves['horaInicio'], 
            $request->horarioJueves['minInicio'], $request->horarioJueves['horaFin'], 
            $request->horarioJueves['minFin']);
        }
        if($request->dias[4] == 'true'){
            $viernes= new Tur_horarioxcola;
            $res *= $viernes->crear($cola->idcola, 6, $request->horarioViernes['horaInicio'], 
            $request->horarioViernes['minInicio'], $request->horarioViernes['horaFin'], 
            $request->horarioViernes['minFin']);
        }
        return response()->json($res);
    }

    public function cola($id){
        $cola = Tur_cola::select('Tur_cola.idcola as idcola', 'descripcion', 'publicado', 'fecha_desde', 
        'fecha_hasta', 'cant_puestos', 'duracion_turno', 'denominacion')
        ->where('idcola', '=', $id)
        ->join('iprodha.tur_tramite tr', 'tr.idtramite', '=', 'Tur_cola.idtramite')
        ->first();
        $horarios = Tur_horarioxcola::where('idcola', '=', $id)->orderBy('dia')->get();  
        $turnos=null;        
        $tr = Tur_turno::where('idcola', '=', $id)->get();
        if( sizeof ($tr) >0){
            $turnos = 1;
        }            
        return view('Sociales.cola')
        ->with('cola', $cola)
        ->with('turnos', $turnos);
    }

    public function turnos_cola($id){
        $cola = Tur_cola::select('Tur_cola.idcola as idcola', 'descripcion', 'publicado', 'fecha_desde', 
        'fecha_hasta', 'cant_puestos', 'duracion_turno', 'denominacion')
        ->where('idcola', '=', $id)
        ->join('iprodha.tur_tramite tr', 'tr.idtramite', '=', 'Tur_cola.idtramite')
        ->first();
        $horarios = Tur_horarioxcola::where('idcola', '=', $id)->orderBy('dia')->get();  
        $arrayTablas = [NULL, NULL, NULL, NULL, NULL];
        for($i=0;$i<sizeof($horarios); $i++){
            $arrayTablas[$horarios[$i]->dia - 2] = floor((($horarios[$i]->hora_hasta - $horarios[$i]->hora_desde)*60+($horarios[$i]->min_hasta - $horarios[$i]->min_desde))/$cola->duracion_turno);
        }    
        $str= '';
        $band = 0;
        if($arrayTablas[0] != NULL){
            $str = ' Lunes';
            $band = 1;
        }
        if($arrayTablas[1] != NULL){
            if($band==0){
                $str = ' Martes';                                            
                $band = 1;
            }
            else{
                $str .= ', Martes';
            }                                       
        }
        if($arrayTablas[2] != NULL){
            if($band==0){
                $str = ' Miércoles';                                            
                $band = 1;
            }
            else{
                $str .= ', Miércoles';
            }    
        }
        if($arrayTablas[3] != NULL){
            if($band==0){
                $str = ' Jueves';                                            
                $band = 1;
            }
            else{
                $str .= ', Jueves';
            }  
        }
        if($arrayTablas[4] != NULL){
            if($band==0){
                $str = ' Viernes';                                            
                $band = 1;
            }
            else{
                $str .= ', Viernes';
            }  
        }
        $turnos=null;        
        $tr = Tur_turno::where('idcola', '=', $id)->get();
        if( sizeof ($tr) >0){
            $turnos = 1;
        }            
        return view('Sociales.turnos_cola')
        ->with('cola', $cola)
        ->with('turnos', $turnos)
        ->with('str', $str);
    }

    public function generarTurnos(Request $request) {
        $cola = Tur_cola::find($request->id);
        $horarios = Tur_horarioxcola::where('idcola', $request->id)->orderBy('dia')->get();
        $res = 1;
        // Convertir las fechas
        $fechaDesde = Carbon::parse($cola->fecha_desde);
        $fechaHasta = Carbon::parse($cola->fecha_hasta);
    
        // Comenzae a generar turnos desde fecha_desde hasta fecha_hasta
        $fecha = $fechaDesde->copy();
    
        while ($fecha <= $fechaHasta) {
            // Check if the current day is one of the specified days for turns
            $dayOfWeek = $fecha->dayOfWeek;
    
            foreach ($horarios as $horario) {
                // Check if the current day matches the specified day for turns
                if (($dayOfWeek + 1) == $horario->dia) {
                    $format = $fecha->format('Y-m-d');
                    $query = "SELECT * from iprodha.feriados where fecha = '$format'";
                
                    $feriado = DB::select( DB::raw($query));
                    if(sizeof($feriado) == 0){
                        // Calculate the number of turns that can fit within the specified time frame
                        $horaInicio = $horario->hora_desde * 60 + $horario->minuto_desde;
                        $horaFin = $horario->hora_hasta * 60 + $horario->minuto_hasta;
                        $duracionTurno = $cola->duracion_turno;
                        $numTurnos = floor(($horaFin - $horaInicio) / $duracionTurno);

                        // Iterate through each turn
                        for ($i = 0; $i < $numTurnos; $i++) {
                            $horaTurno = $horaInicio + ($duracionTurno * $i);
                            $hora = floor($horaTurno / 60);
                            $minuto = $horaTurno % 60;

                            // Generate the turn for each available position
                            for ($j = 0; $j < $cola->cant_puestos; $j++) {
                                $turno = new Tur_turno;
                                $res *= $turno->crear($request->id, $fecha->format('Y-m-d'), $hora, $minuto, $j + 1, null); // Assuming dni can be null
                            }
                        }
                    }
                    
                }
            }
    
            // Move to the next day
            $fecha->addDay();
        }
        return response()->json($res);
    }

    public function getTurnosByFecha(Request $request){
        $turnos = Tur_turno::select('idturno', 'idcola', 'fecha', 'hora', 'minuto', 'puesto', 'dni', 'nombre')
        ->leftJoin('iprodha.in_titular t', 't.dnitit', '=', 'iprodha.tur_turno.dni')
        ->where('idcola', '=', $request->id)
        ->where('fecha', '=', $request->fecha)
        ->orderBy('hora')->orderBy('minuto')->get();
        return response()->json($turnos);
    }

    public function verificarUsuario(Request $request){
        $query = "SELECT nombre FROM iprodha.in_titular WHERE DNITIT = $request->dni";
        $user = DB::select( DB::raw($query));
        return response()->json($user);
    }

    public function reservarTurno(Request $request){
        $turno = Tur_turno::find($request->id);
        $turno->dni = $request->dni;
        return response()->json($turno->save());
    }

    public function borrarCola(Request $request){
        $cola=Tur_cola::find($request->id);
        $query = "SELECT * from iprodha.tur_turno 
        where dni is not null and idcola= $request->id";
        $vacio = DB::select( DB::raw($query));
        if(sizeof($vacio) == 0){
            $horario=Tur_horarioxcola::where('idcola', '=', $cola->idcola)->delete();        
            $turnos = Tur_turno::where('idcola', '=', $cola->idcola)->delete();
            return response()->json($cola->delete());
        }
        else{
            return response()->json(-1);
        }
    }    

    public function publicarCola(Request $request){
        $cola=Tur_cola::find($request->id);
        $cola->publicado = 1;
        return $cola->save();
    }
    
    public function borrarTurno(Request $request){
        $turno = Tur_turno::find($request->id);
        $turno->dni = '';
        return response()->json($turno->save());
    }
}
