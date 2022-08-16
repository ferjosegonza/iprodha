 @extends('layouts.app')

 @section('content')
 <?php
 # comentario
 // otra forma de comentar
 /*   
 <html><head></head><body>hola mundo desde la Vista!</body></html>;
Coemtario multilínea
 */
 print('hola mundo');

 # Variables

 //http://192.168.10.84/nuevosistema/public/viajes?aeropuerto=Ezeiza
 # GET llegan por la URL
 //if(!$_GET["aeropuerto"] ) { //Si no se envía el parámetro
/*if(isset($_GET["aeropuerto"])) { //Si existe el parámetro y tiene valor
    $origen .="(No especificado)";
 }
 else {
    $origen .='(' . $_GET["aeropuerto"] . ')';
}
$origen = comprobarOrigen(); //Ejecuta la función definida
echo "<hr>";
echo $origen;

echo "<hr>";
$existe = existeParametro("aeropuerto");
echo $existe;

# Funciones
function comprobarOrigen(){
    $origen = "Buenos Aires";
    $destino = "Londres";
    $destino .= "(Heathrow)";
    if(isset($_GET["aeropuerto"])) { //Si existe el parámetro y tiene valor
        $origen .='(' . $_GET["aeropuerto"] . ')';       
     }
     else {
        $origen .="(No especificado)";
    }
    echo  "<h1>" . 'Origen: ' . $origen . ', Destino: ' . $destino . "</h1>";
    return $origen;
}

function existeParametro($parametro){
    if(isset($_GET["$parametro"])) { 
        $valor ='Existe:' . $_GET["$parametro"];
     }
     else {
        $valor ='No existe el Parámetro';
    } 
    return $valor;
}

# Array 
$aerolineas =["Iberia", "British Airways", "Aerolineas Argentinas"];
echo "<hr>";
echo $aerolineas[2];

?>


<h1> Listado </h1>
<ul> 
    <?php
    foreach ($aerolineas as $nombre) {
        echo "<li> $nombre </li>";
    }
    ?>
</ul>

@endsection
