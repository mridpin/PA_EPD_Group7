<?php

$gasolineras = array();
$numPrecio = 0;

function trataLinea($linea) {
    global $gasolineras;
    global $numPrecio;
    
    $atributos = explode(";", $linea);
    $date = explode(" ", $atributos[0]);
    
    for ($i = 0; $i < count($date); $i++) {
        $date_price = explode("-", $date[$i]);
        $gasolineras[$numPrecio]["g"] = $atributos[1];
        $gasolineras[$numPrecio]["tipo"] = $atributos[2];
        $gasolineras[$numPrecio]["fecha"] = strtotime(str_replace("/","-",$date_price[0]))+ 80000;
        $gasolineras[$numPrecio]["precio"] = $date_price[1];
        $numPrecio++;
   }
} 

function imprimir(){
    global $gasolineras;
    
    echo "<h1> Tabla de precios </h1>";

    echo "<table border=1>"
    . "<tr>"
    . "<th>Fecha</th>"
    . "<th>Precio</th>"
    . "<th>Gasolinera</th>"
    . "<th>Criterio</th>"
    . "</tr>";
    
    foreach($gasolineras as &$var){
        echo "<tr>";
        echo "<td>" .  gmdate("d-m-y", $var["fecha"]) ."</td>";
        echo "<td>" . $var["precio"] . "</td>";
        echo "<td>" . $var["g"] . "</td>";
        echo "<td>" . $var["tipo"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

if (isset($_POST['envio'])) {

    if (!isset($_POST['info'])) {
        echo 'Error: No se ha definido ninguna gasolinera<br />';
    } else {
        $info = $_POST['info'];
        $lineas = explode("\n", $info);

        for ($i = 0; $i < count($lineas); $i++) {
            trataLinea($lineas[$i]);
        }
        
        imprimir();
    }
}
