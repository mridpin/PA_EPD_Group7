function suma(oper1, oper2) {
    return (oper1+oper2);
}
function resta(oper1, oper2) {
    return (oper1-oper2);
}
function mult(oper1, oper2) {
    return (oper1*oper2);
}
function div(oper1, oper2) {
    return (oper1/oper2);
}
function verificarPrimitiva(){
    var str = "";
    var count = 0;
    //ALMACENAMOS LA INFORMACION
    var ganador = prompt("Introduce el numero ganador: ");
    var jugadores = prompt("Introduce el la cadena de ganadores: ");
    var ganadorArray = ganador.split(" ");
    var jugadoresArray = jugadores.split(";");
    var jugadoresBiArray = new Array();
    for (var i = 0; i < jugadoresArray.length; i++) {
        jugadoresBiArray.push(jugadoresArray[i].split(" "));
    }


    //CREAMOS ARRAY CON EL NUMERO DE ACIERTOS
    var jugadoresRes = new Array();
    for (var i = 0; i < jugadoresBiArray.length; i++) {
        count=0;

        for (var j = 0; j < jugadoresBiArray[0].length; j++) {
            if (jugadoresBiArray[i][j] == ganadorArray[j]) {
                count++;
            }
        }
        jugadoresRes.push([jugadoresBiArray[i][0]+jugadoresBiArray[i][1]+jugadoresBiArray[i][2]+jugadoresBiArray[i][3]+jugadoresBiArray[i][4]+jugadoresBiArray[i][5],count,Math.pow(10,count),jugadoresBiArray[i][6]]);
    }

    //Funcion de comparacion y ordenamos
    function compare(a,b) {
        if (a[1] < b[1])
          return 1;
        if (a[1] > b[1])
          return -1;
        return 0;
    }

    jugadoresRes.sort(compare);

    //Imprimimos la tabla
    str+="<table><tr><th>Numero</th><th>Aciertos</th><th>Dinero Ganado</th><th>Jugador</th></tr>";
    for (var i = 0; i < jugadoresRes.length; i++) {
        var coincidencias = parseInt(jugadoresRes[i][1]);
        dineroGanado = Math.pow(10,coincidencias);
        str+="<tr><td>" + jugadoresRes[i][0] + "</td><td>" + jugadoresRes[i][1]  + "</td><td>" + jugadoresRes[i][2]  + "</td><td>" + jugadoresRes[i][3]  + "</td></tr>";
    }
    str+="</table>";

    //Mandar resultado
    document.getElementById('res').innerHTML = str;
}
