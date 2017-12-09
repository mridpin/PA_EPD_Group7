function selectCine(select) {
    var cine = select.value;

    removeAllChilds("cartelera");

    var sectionRef = document.getElementsByTagName("section")[0];
    sectionRef.style.display = "block";

    switch (cine) {
        case "cinesur":
            var cartelera = [
                ["Coco", "16:30", "17:30", "18:00", "19:00", "19:15", "20:00", "21:00"],
                ["Asesinato en el Orient Express", "16:45", "17:30", "18:30", "19:15", "19:30", "20:00", "21:00", "22:00", "23:00"],
                ["La Liga de La Justicia", "18:30", "19:00", "19:30", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00"],
                ["Saw VIII", "18:05", "18:45", "19:00", "19:15", "19:30", "20:30", "21:00", "22:30", "23:00"],
                ["Wonder", "16:55", "17:15", "18:00", "19:15", "20:30", "21:30", "22:00", "22:30", "23:00"]
            ];
            printCartelera(cartelera);
            break;
        case "cinemas7":
            var cartelera = [
                ["Coco", "16:30", "17:30", "18:00", "19:00", "19:15", "20:00", "21:00"],
                ["El sacrificio de un ciervo sagrado", "16:45", "17:30", "18:30", "19:15", "19:30", "20:00", "21:00", "22:00", "23:00"],
                ["Feliz Dia de Tu Muerte", "18:30", "19:00", "19:30", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00"],
                ["Saw VIII", "16:55", "17:15", "18:00", "19:15", "20:30", "21:30", "22:00", "22:30", "23:00"],
                ["La Liga de La Justicia", "18:05", "18:45", "19:00", "19:15", "19:30", "20:30", "21:00", "22:30", "23:00"]
            ];
            printCartelera(cartelera);
            break;
        case "cineAbaco":
            var cartelera = [
                ["La Liga de La Justicia", "16:30", "17:30", "18:00", "19:00", "19:15", "20:00", "21:00"],
                ["Wonder", "16:45", "17:30", "18:30", "19:15", "19:30", "20:00", "21:00", "22:00", "23:00"],
                ["Asesinato en el Orient Express", "18:30", "19:00", "19:30", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00"],
                ["Dos padres por desigual", "18:05", "18:45", "19:00", "19:15", "19:30", "20:30", "21:00", "22:30", "23:00"],
                ["La libreria", "16:55", "17:15", "18:00", "19:15", "20:30", "21:30", "22:00", "22:30", "23:00"]
            ];
            printCartelera(cartelera);
            break;
        default :
            sectionRef.style.display = "none";
            break;

    }
}

function isNumber(e) {
    var pnum = /^[0-9]+$/;
    var keynum = e.which;

    var keychar = String.fromCharCode(keynum);
    return ((pnum.test(keychar) || keynum == 8 || keynum == 0) && fourDigits());
}

function fourDigits(){
    var hora = document.getElementsByTagName("input")[0].value;
    return (hora.length < 4 );
}

function printCartelera(cartelera) {
    var carteleraRef = document.getElementById("cartelera");
    var path = "img/";
    var ext = ".jpg";

    for (var i = 0; i < cartelera.length; i++) {
        var pelicula = document.createElement("div");
        pelicula.setAttribute("class", "pelicula");

        var titulo = document.createElement("h3");
        var title = document.createTextNode(cartelera[i][0]);
        titulo.appendChild(title);

        var cartel = document.createElement("div");
        var img = document.createElement("img");

        var nameImg = replaceAll(cartelera[i][0]," ","_");

        img.setAttribute("src", path + nameImg + ext);
        img.setAttribute("alt", cartelera[i][0]);
        cartel.appendChild(img);

        var horas = document.createElement("div");
        horas.setAttribute("class", "horas");

        for (var j = 1; j < cartelera[i].length; j++) {

            var hora = document.createElement("div");
            var text = document.createTextNode(cartelera[i][j]);
            hora.appendChild(text);
            horas.appendChild(hora);
        }

        pelicula.appendChild(titulo);
        pelicula.appendChild(cartel);
        pelicula.appendChild(horas);
        carteleraRef.appendChild(pelicula);
    }
}

function changeHora(hora){
    if (hora.value.length === 4) {
        var horas = document.getElementsByClassName("horas");
        for (var i = 0; i < horas.length; i++) {
            var listHoras = horas[i].childNodes;
            for (var j = 0; j < listHoras.length; j++) {
                if(hora.value <= listHoras[j].textContent.replace(":","")){
                    listHoras[j].style.fontWeight = "900";
               }else{
                   listHoras[j].style.fontWeight = "normal";
               }
            }
        }
        document.getElementsByTagName("input")[0].value = "";
    }
}

function removeAllChilds(name){
    var parent = document.getElementById(name);
    while(parent.hasChildNodes()){
        parent.removeChild(parent.firstChild);
    }
}

function replaceAll(text, search, newstring ){
    while (text.toString().indexOf(search) != -1)
        text = text.toString().replace(search,newstring);
    return text;
}
