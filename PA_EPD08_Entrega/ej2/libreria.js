/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generarTabla(){
    var valor = parseInt(document.getElementById('in1').value);
    var wrap = document.getElementById("wrap");

    var table = document.createElement("table");
    wrap.appendChild(document.createTextNode("Lista de compañias:"));
    wrap.appendChild(document.createElement("br"));
    wrap.appendChild(table);

    var row = document.createElement("tr");
    table.appendChild(row);

    celda = document.createElement("th");
    text = document.createTextNode("Compañia");
    celda.appendChild(text);
    row.appendChild(celda);

    for (var i = 0; i < 20; i++) {
        celda = document.createElement("th");
        text = document.createTextNode((i+1).toString());
        celda.appendChild(text);
        row.appendChild(celda);
    }

    var compañias = [];
    //Creamos las compañias
    for (var i = 0; i < valor; i++) {
        //generamos valores para cada compañia
        var valores = ["Compañia "  + (i+1),Math.floor((Math.random() * 50) + 1)];
        for (var j = 0; j < 19; j++) {
            valores.push(Math.floor((Math.random() * 50) + 1));
        }
        compañias.push(valores);
    }

    //Generamos el resto de la tabla principal
    for (var i = 0; i < compañias.length; i++) {

        var row = document.createElement("tr");
        table.appendChild(row);

        celda = document.createElement("td");
        text = document.createTextNode(compañias[i][0]);
        celda.appendChild(text);
        row.appendChild(celda);

        celda = document.createElement("td");
        text = document.createTextNode(compañias[i][1]);
        celda.appendChild(text);
        row.appendChild(celda);

        for (var j = 2; j < 21; j++) {
            celda = document.createElement("td");
            if (compañias[i][j] > compañias[i][j-1]){
                text = document.createTextNode("↑");
            }else if (compañias[i][j] < compañias[i][j-1]){
                text = document.createTextNode("↓");
            }else{
                text = document.createTextNode("=");
            }
            celda.appendChild(text);
            row.appendChild(celda);
        }
    }
    wrap.appendChild(document.createElement("br"));
    wrap.appendChild(document.createElement("br"));
    wrap.appendChild(document.createTextNode("Compañias ordenadas por mejor balance:"));
    wrap.appendChild(document.createElement("br"));
    //Copiamos un nuevo array y lo ordenamos
    var compañiasOrdenadas = compañias;
    compañiasOrdenadas.sort(compare);


    //Imprimimos la tabla ordenado por el ultimo valor de todos los registros de cada compañia
    var table = document.createElement("table");
    wrap.appendChild(table);

    var row = document.createElement("tr");
    table.appendChild(row);

    celda = document.createElement("th");
    text = document.createTextNode("Compañia");
    celda.appendChild(text);
    row.appendChild(celda);

    for (var i = 0; i < 5; i++) {
        celda = document.createElement("th");
        text = document.createTextNode((i+1).toString());
        celda.appendChild(text);
        row.appendChild(celda);
    }
    for (var i = 0; i < compañiasOrdenadas.length; i++) {

        var row = document.createElement("tr");
        table.appendChild(row);

        celda = document.createElement("td");
        text = document.createTextNode(compañiasOrdenadas[i][0] + " (Ultimos 5 dias): ");
        celda.appendChild(text);
        row.appendChild(celda);

        for (var j = 16; j < 20; j++) {
            celda = document.createElement("td");
            if (compañiasOrdenadas[i][j] > compañiasOrdenadas[i][j-1]){
                text = document.createTextNode("↑");
            }else if (compañiasOrdenadas[i][j] < compañiasOrdenadas[i][j-1]){
                text = document.createTextNode("↓");
            }else{
                text = document.createTextNode("=");
            }
            celda.appendChild(text);
            row.appendChild(celda);
        }

        celda = document.createElement("td");
        text = document.createTextNode(compañiasOrdenadas[i][20]);
        celda.appendChild(text);
        row.appendChild(celda);
    }

    //Quitamos el boton
    document.getElementById("mybtn").disabled = true;

}

function compare(a,b) {
        if (a[20] < b[20])
          return 1;
        if (a[20] > b[20])
          return -1;
        return 0;
}
