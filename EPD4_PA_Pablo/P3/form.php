<?php

$gasolineras = array();
$numPrecio = 0;

function trataLinea($linea) {
    global $gasolineras;
    global $numPrecio;
    
    for ($i = 0; $i < $_POST['mediciones']; $i++) {
        $splitfecha = split("-", $_POST["fecha$i"]);
        if ($splitfecha[1]==$_POST['mes']) {
            $gasolineras[$numPrecio]["g"] = "CEPSA";
            $gasolineras[$numPrecio]["tipo"] = "MAXIMO";
            $gasolineras[$numPrecio]["fecha"] = strtotime(str_replace("/","-",$_POST["fecha$i"]))+ 80000;
            $gasolineras[$numPrecio]["precio"] = $_POST["precio$i"]-($_POST["precio$i"]*($_POST["descuento"]*0.01));
            $numPrecio++;
        }
        
   }
} 

function cmpPrecio($x,$y){
    
    if ($x["precio"] == $y["precio"]) {
        return 0;
    }
    return ($x["precio"] < $y["precio"]) ? -1 : 1;
}

function cmpPrecioM($x,$y){
    
    if ($x["precio"] == $y["precio"]) {
        return 0;
    }
    return ($x["precio"] > $y["precio"]) ? -1 : 1;
}

function cmpFecha($x,$y){

    if ($x["fecha"] == $y["fecha"]) {
        return 0;
    }
    return ($x["fecha"] < $y["fecha"]) ? -1 : 1;
}

function cmpFechaM($x,$y){

    if ($x["fecha"] == $y["fecha"]) {
        return 0;
    }
    return ($x["fecha"] > $y["fecha"]) ? -1 : 1;
}

function imprimir($criterio,$orden){
    global $gasolineras;
    
    echo "<h1> Tabla de precios </h1>";

    echo "<table border=1>"
    . "<tr>"
    . "<th>Fecha</th>"
    . "<th>Precio</th>"
    . "<th>Gasolinera</th>"
    . "<th>Criterio</th>"
    . "</tr>";
    
    switch($orden){
        
        case "mayorMenor":
            if ($criterio=="precio") {
                
                uasort($gasolineras, 'cmpPrecioM');
            }else{
                uasort($gasolineras, 'cmpFechaM');
            }
            
            break;
        
        case "menorMayor":
            if ($criterio=="fecha") {
                uasort($gasolineras, 'cmpFecha');
            }else{
                uasort($gasolineras, 'cmpPrecio');
            }
            break;
            
        default:
            break;
    }
    foreach($gasolineras as &$var){
        echo "<tr>";
        echo "<td>" .  gmdate("d-m-y", $var["fecha"]) ."</td>";
        echo "<td>" . $var["precio"] . "</td>";
        echo "<td>" . $var["g"] . "</td>";
        echo "<td>" . $var["tipo"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    if(isset($_POST['media'])){
        $media = 0;
        for ($i = 0; $i < count($gasolineras); $i++){
            $media += str_replace(",",".",$gasolineras[$i]["precio"]);
        }
        echo "<br> Media de los precios de las tomas: " . (float)$media;
    }
}

if (isset($_POST['envio'])) { 
        $lineas = $_POST['mediciones'];
        for ($i = 0; $i < count($lineas); $i++) {
            trataLinea($lineas[$i]);
        }
        imprimir($_POST['cols'], $_POST['select']);
    
}
