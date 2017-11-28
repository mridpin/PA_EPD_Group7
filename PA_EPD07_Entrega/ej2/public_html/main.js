var n =  prompt("Introduce numero: ");
var accuracy = prompt("Cifras decimales al redondeo: ");
var number = n.split(".");

var decimals = number[1].split("");
if(decimals != null){
if (decimals.length > accuracy) {
    var fix = accuracy, round = fix-1;
    var overflow = 0;
    var value = 0;

    do {
        if (overflow) {
            fix--;
            round--;
            if(round < 0){
                value = parseInt(number[0]);
                number[0] = "" + ++value;
            }
            overflow = 0;
        }
        if(round >= 0){
            if(decimals[fix] >= "5"){
                value = parseInt(decimals[round]);
                if ((value+1) > 9) {
                    overflow++;
                }
                decimals[round] = ++value;
            }
        }


    } while (overflow);

    decimals = decimals.slice(0,fix);
}

if (accuracy > decimals.length) {
    while(decimals.push("0") < accuracy);
}

decimals = "." + decimals.join("");
number = number[0].concat(decimals);

document.write("El resultado de redondear \"" + n + "\" a \"" + accuracy  + "\"  es " + number);
}else{document.write("Error has introducido un numero entero, no decimal")};
