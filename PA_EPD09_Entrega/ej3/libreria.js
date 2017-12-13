/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generarTabla(){
    var ids = 0;
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
            img = document.createElement("img");
            if (compañias[i][j] > compañias[i][j-1]){
                img.setAttribute("src","up.jpg");
            }else if (compañias[i][j] < compañias[i][j-1]){
                img.setAttribute("src","down.jpg");
            }else{
                img.setAttribute("src","same.jpg");
                
            }
            img.setAttribute("alt",compañias[i][j]);
            img.setAttribute("id",ids);
            img.setAttribute("onmouseover","mouseIn(this)");
            img.setAttribute("onclick","mouseClick(this)");
            var precio = document.createElement("span");
            precio.textContent = compañias[i][j];
            precio.setAttribute("id","s"+ids);
            celda.appendChild(img);
            celda.appendChild(precio);
            row.appendChild(celda);
            precio.style.opacity = 0;
            ids++;
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
            img = document.createElement("img");
            if (compañiasOrdenadas[i][j] > compañiasOrdenadas[i][j-1]){
                img.setAttribute("src","up.jpg");
            }else if (compañiasOrdenadas[i][j] < compañiasOrdenadas[i][j-1]){
                img.setAttribute("src","down.jpg");
            }else{
                img.setAttribute("src","same.jpg");
                
            }
            img.setAttribute("alt",compañiasOrdenadas[i][j]);
            img.setAttribute("id",ids);
            img.setAttribute("onmouseover","mouseIn(this)");
            img.setAttribute("onclick","mouseClick(this)");
            celda.appendChild(img);
            var precio = document.createElement("span");
            precio.textContent = compañias[i][j];
            precio.setAttribute("id","s"+ids);
            celda.appendChild(precio);
            row.appendChild(celda);
            precio.style.opacity = 0;
            ids++;
        }
        
        celda = document.createElement("td");
        text = document.createTextNode(compañiasOrdenadas[i][20]);
        celda.appendChild(text);
        row.appendChild(celda);
    }



    //Quitamos el boton
    document.getElementById("mybtn").disabled = true;
    
}


function mouseIn(value){
    var text = value.getAttribute('alt');
    var html = value.innerHTML;
    var id = value.getAttribute('id');
    $("#s" + id).animate({
        'opacity':'1'
    },400);
    
    $("#" + id).mouseout(function(){
        $("#s" + id).animate({
            'opacity':'0'
        },400);
    });
}

function mouseClick(value){
    
    var id = value.getAttribute('id');
    $("img").css({"opacity": "0.3","width": "8px","height": "8px"});
    $("#" + id).css({"opacity": "1","width": "20px","height": "20px"});
}


function compare(a,b) {
        if (a[20] < b[20])
          return 1;
        if (a[20] > b[20])
          return -1;
        return 0;
}