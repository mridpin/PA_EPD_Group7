var errors;

function createAllForm(numFam) {
    var sectionRef = document.getElementsByTagName("section")[0];
    sectionRef.removeChild(sectionRef.childNodes[2]);

    var form = document.createElement("form");
    form.setAttribute("id", "formfamiliars");
    form.setAttribute("onsubmit", "return validaFormulario()");
    for (var i = 0, n = 1; i < numFam.value; i++, n++) {

        crearForm(form, n);
    }
    var send = document.createElement("input");
    send.setAttribute("type", "submit");
    send.setAttribute("name", "send");
    send.setAttribute("value", "Enviar");
    form.appendChild(send);

}

function crearForm(form, iter) {

    var div = document.createElement("div");
    div.setAttribute("id", "fam" + iter);
    var title = document.createElement("h2");
    var text = document.createTextNode("Familiar " + iter);
    title.appendChild(text);
    div.appendChild(title);

    var divError = document.createElement("div");
    divError.setAttribute("class", "error");

    div.appendChild(divError);

    var inputName = document.createElement("input");
    inputName.setAttribute("type", "text");
    inputName.setAttribute("name", "name");
    inputName.setAttribute("id", "name"+iter);
    inputName.setAttribute("placeholder", "Nombre");
    inputName.setAttribute("onchange", "validationName(this)");
    div.appendChild(inputName);

    var inputLastName = document.createElement("input");
    inputLastName.setAttribute("type", "text");
    inputLastName.setAttribute("name", "lastname");
    inputLastName.setAttribute("id", "lastname"+iter);
    inputLastName.setAttribute("placeholder", "Apellidos");
    inputLastName.setAttribute("onchange", "validationLastName(this)");
    div.appendChild(inputLastName);

    var inputTail = document.createElement("input");
    inputTail.setAttribute("type", "text");
    inputTail.setAttribute("name", "tail");
    inputTail.setAttribute("id", "tail"+iter);
    inputTail.setAttribute("placeholder", "Altura");
    inputTail.setAttribute("onchange", "validationTail(this)");
    div.appendChild(inputTail);

    var civilArray = ["Soltero", "Casado", "Divorciado", "Viudo"];
    var selectCivil = document.createElement("select");
    selectCivil.setAttribute("name", "state");
    selectCivil.setAttribute("id", "state"+iter);
    selectCivil.setAttribute("onchange", "validationState(this)");

    var option = document.createElement("option");
    text = document.createTextNode("--Seleccione uno--");
    option.appendChild(text);

    selectCivil.appendChild(option);

    for (var i = 0; i < 4; i++) {
        option = document.createElement("option");
        text = document.createTextNode(civilArray[i]);
        option.setAttribute("value", civilArray[i]);
        option.appendChild(text);

        selectCivil.appendChild(option);
    }
    div.appendChild(selectCivil);

    var inputWeb = document.createElement("input");
    inputWeb.setAttribute("type", "text");
    inputWeb.setAttribute("name", "web");
    inputWeb.setAttribute("id", "web"+iter);
    inputWeb.setAttribute("placeholder", "Web Personal");
    inputWeb.setAttribute("onchange", "validationNamber(this)");
    div.appendChild(inputWeb);

    var inputNumber = document.createElement("input");
    inputNumber.setAttribute("type", "text");
    inputNumber.setAttribute("name", "number");
    inputNumber.setAttribute("id", "number"+iter);
    inputNumber.setAttribute("placeholder", "Numero telefono");
    inputNumber.setAttribute("onchange", "validationNamber(this)");
    div.appendChild(inputNumber);

    var sex = document.createElement("div");
    var labelM = document.createElement("label");
    text = document.createTextNode("Hombre");
    labelM.appendChild(text);
    sex.appendChild(labelM);

    var inputSexoM = document.createElement("input");
    inputSexoM.checked = true;
    inputSexoM.setAttribute("type", "radio");
    inputSexoM.setAttribute("name", "sex"+iter);
    inputSexoM.setAttribute("value", "male");
    sex.appendChild(inputSexoM);

    var labelF = document.createElement("label");
    text = document.createTextNode("Mujer");
    labelF.appendChild(text);
    sex.appendChild(labelF);

    var inputSexoF = document.createElement("input");
    inputSexoF.setAttribute("type", "radio");
    inputSexoF.setAttribute("name", "sex"+iter);
    inputSexoF.setAttribute("value", "female");
    sex.appendChild(inputSexoF);

    div.appendChild(sex);
    form.appendChild(div);

    var sectionRef = document.getElementsByTagName("section")[0];
    sectionRef.appendChild(form);

}

function validationName(input){
    var exp = /^[a-zA-Z]*$/;

    return exp.test(input.value) && input.value!=="";
}

function validationLastName(input){
    var exp = /^[a-zA-Z]*$/;

    return exp.test(input.value) && input.value!=="";
}

function validationTail(input){
    var exp = /^[1-2][0-9][0-9]$/;
    return exp.test(input.value) && input.value!=="";
}

function validationState(input){
    switch(input.value){
        case "Soltero":
            valid = true;
            break;
        case "Casado":
            valid = true;
            break;
        case "Divorciado":
            valid = true;
            break;
        case "Viudo":
            valid = true;
            break;
        default:
            valid = false;
            break;
    }
    return valid;
}

function validationWeb(input){
    var exp = /^([w][w][w][.][a-z 0-9]{3,30}[.][a-z]{2,7}[/][a-z 0-9]{3,30})$/;

    return exp.test(input.value) && input.value!=="";
}

function validationNamber(input){
    var exp = /^6[0-9]{8}$/;

    return exp.test(input.value) && input.value!=="";
}

function validaFormulario(){
    errors = "";
    var inputs = document.getElementsByTagName("input");

    for (var i = 0; i < inputs.length; i++) {
        switch(inputs[i].getAttribute("name")){
            case "name":
                if (!validationName(inputs[i])) {
                    console.log();
                    errors += inputs[i].parentNode.getAttribute("id") +"-Error campo Nombre, solo letras, no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";
                }else{
                    inputs[i].style.border = "none";
                }
                break;
            case "lastname":
                if (!validationLastName(inputs[i])) {
                    errors += inputs[i].parentNode.getAttribute("id") +"-Error campo Apellidos, solo letras, no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";
                }else{
                    inputs[i].style.border = "none";
                }

                break;
            case "tail":
                if (!validationTail(inputs[i])) {
                    errors +=inputs[i].parentNode.getAttribute("id") +"-Error campo Altura, numerico 100-299, no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";
                }else{
                    inputs[i].style.border = "none";
                }

                break;
            case "state":
                if (!validationState(inputs[i])) {
                    errors += inputs[i].parentNode.getAttribute("id") +"-Error campo Estado, no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";

                }else{
                    inputs[i].style.border = "none";
                }

                break;
            case "web":
                if (!validationWeb(inputs[i])) {
                    errors += inputs[i].parentNode.getAttribute("id") +"-Error campo Web, formato www.pagina.com/cadena , no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";
                }else{
                    inputs[i].style.border = "none";
                }

                break;
            case "number":
                if (!validationNamber(inputs[i])) {
                    errors += inputs[i].parentNode.getAttribute("id") +"-Error campo Numero Telefono, numerico, 6XXXXXXXX, no puede estar vacío;";
                    inputs[i].style.border = "1px solid red";
                }else{
                    inputs[i].style.border = "none";
                }

                break;
        }
    }

    var select = document.getElementsByTagName("select");
    for (i = 0; i < select.length; i++) {
        if (!validationState(select[i])) {
            errors += select[i].parentNode.getAttribute("id") +"-Error campo Estado;";
            select[i].style.border = "1px solid red";

        }else{
            select[i].style.border = "none";
        }
    }

    if (errors!=="") {
        printErrors();
        return false;
    }else{
        return true;
    }
}

function printErrors(){
    var divErrorsRef = document.getElementsByClassName("error");

    for (var i = 0; i < divErrorsRef.length; i++) {
        removeAllChilds(divErrorsRef[i]);
    }
    var errorsArray = errors.split(";");

    for (i = 0; i < divErrorsRef.length; i++) {

        for (var j = 0; j < errorsArray.length; j++) {
            var aux = errorsArray[j].split("-");
            if (aux[0]===divErrorsRef[i].parentElement.getAttribute("id")) {

                var span = document.createElement("span");
                var text = document.createTextNode(aux[1] + " | ");
                span.style.color = "red";
                span.appendChild(text);
                divErrorsRef[i].appendChild(span);
            }
        }
    }
}

function removeAllChilds(parent){
    while (parent.hasChildNodes()){
        console.log("borrando - " + parent.firstChild);
        parent.removeChild(parent.firstChild);
    }
}
