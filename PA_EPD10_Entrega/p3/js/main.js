var errors;
var numFam;

function listenerForm(){
    $("#numFam").on("keydown", function (evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });

    $("#numFam").on("change", function () {
        numFam = $(this).val();
        createAllForm(numFam);
    });
}

function createAllForm(numFam) {
    var sectionRef = $("section")[0];
    sectionRef.removeChild(sectionRef.childNodes[2]);

    var form = document.createElement("form");
    form.setAttribute("id", "formfamiliars");
    form.setAttribute("method", "post");

    for (var i = 0, n = 1; i < numFam; i++, n++) {

        var divsRef = crearForm(form, n);

    }

    var send = document.createElement("input");
    send.setAttribute("type", "submit");
    send.setAttribute("name", "send");
    send.setAttribute("value", "Enviar");
    form.appendChild(send);

    sectionRef.appendChild(form);

    $.validator.setDefaults({
        submitHandler: function() {
            alert("submitted!");
        }
    });
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });
    $.validator.addMethod("valueNotEquals", function(value, element, arg){
     return arg != value;
    }, "Value must not equal arg.");

    $("#formfamiliars").validate({});

    $('.inputName').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required:  "Por favor introduce tu Nombre",
            }
        });
    });
    $('.inputLastName').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required:  "Por favor introduce tus Apellidos",
            }
        });
    });
    $('.inputTail').each(function() {
        $(this).rules('add', {
            required: true,
            range: [100, 299],
            number: true,
            messages: {
                required: "Por favor introduce tu Altura",
                number: "Debe ser un numero",
                range: "Debe estar entre 100 y 299",
            }
        });
    });
    $('.selectCivil').each(function() {
        $(this).rules('add', {
            valueNotEquals: "--Seleccione uno--" ,
            messages: {
                valueNotEquals: "Por favor selecciona un Estado",
            }
        });
    });
    $('.inputWeb').each(function() {
        $(this).rules('add', {
            required: true,
            url: true,
            messages: {
                required: "Por favor introduce una Web",
                url: "Por favor introduce una formato valido",
            }
        });
    });

    $(".chosen").chosen();
}

function crearForm(form, iter) {

    var div = document.createElement("div");

    div.setAttribute("id", "fam" + iter);
    var title = document.createElement("h2");
    var text = document.createTextNode("Familiar " + iter);
    title.appendChild(text);
    div.appendChild(title);

    var inputName = document.createElement("input");
    inputName.setAttribute("type", "text");
    inputName.setAttribute("name", "name" + iter);
    inputName.setAttribute("class", "inputName");
    inputName.setAttribute("id", "name" + iter);
    inputName.setAttribute("placeholder", "Nombre");

    div.appendChild(inputName);

    var inputLastName = document.createElement("input");
    inputLastName.setAttribute("type", "text");
    inputLastName.setAttribute("name", "lastname" + iter);
    inputLastName.setAttribute("class", "inputLastName");
    inputLastName.setAttribute("id", "lastname" + iter);
    inputLastName.setAttribute("placeholder", "Apellidos");

    div.appendChild(inputLastName);

    var inputTail = document.createElement("input");
    inputTail.setAttribute("type", "text");
    inputTail.setAttribute("name", "tail" + iter);
    inputTail.setAttribute("class", "inputTail");
    inputTail.setAttribute("id", "tail" + iter);
    inputTail.setAttribute("placeholder", "Altura");

    div.appendChild(inputTail);

    var civilArray = ["Soltero", "Casado", "Divorciado", "Viudo"];
    var selectCivil = document.createElement("select");
    selectCivil.setAttribute("name", "state" + iter);
    selectCivil.setAttribute("class", "selectCivil chosen");
    selectCivil.setAttribute("id", "state" + iter);


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

    var inputBirthday = document.createElement("input");
    inputBirthday.setAttribute("type", "date");
    inputBirthday.setAttribute("name", "birthday" + iter);
    inputBirthday.setAttribute("id", "birthday" + iter);
    inputBirthday.setAttribute("placeholder", "Fecha Nacimineto");

    div.appendChild(inputBirthday);

    var inputWeb = document.createElement("input");
    inputWeb.setAttribute("type", "text");
    inputWeb.setAttribute("name", "web" + iter);
    inputWeb.setAttribute("class", "inputWeb");
    inputWeb.setAttribute("id", "web" + iter);
    inputWeb.setAttribute("placeholder", "Web Personal");

    div.appendChild(inputWeb);

    var inputNumber = document.createElement("input");
    inputNumber.setAttribute("type", "text");
    inputNumber.setAttribute("name", "number" + iter);
    inputNumber.setAttribute("id", "number" + iter);
    inputNumber.setAttribute("placeholder", "Numero telefono");
    div.appendChild(inputNumber);

    var sex = document.createElement("div");
    var labelM = document.createElement("label");
    text = document.createTextNode("Hombre");
    labelM.appendChild(text);
    sex.appendChild(labelM);

    var inputSexoM = document.createElement("input");
    inputSexoM.checked = true;
    inputSexoM.setAttribute("type", "radio");
    inputSexoM.setAttribute("name", "sex" + iter);
    inputSexoM.setAttribute("value", "male");
    sex.appendChild(inputSexoM);

    var labelF = document.createElement("label");
    text = document.createTextNode("Mujer");
    labelF.appendChild(text);
    sex.appendChild(labelF);

    var inputSexoF = document.createElement("input");
    inputSexoF.setAttribute("type", "radio");
    inputSexoF.setAttribute("name", "sex" + iter);
    inputSexoF.setAttribute("value", "female");
    sex.appendChild(inputSexoF);

    div.appendChild(sex);
    form.appendChild(div);

    return div.getAttribute("id");
}

function validationName(input) {
    var exp = /^[a-zA-Z]*$/;

    return exp.test(input.value) && input.value !== "";
}

function validationLastName(input) {
    var exp = /^[a-zA-Z]*$/;

    return exp.test(input.value) && input.value !== "";
}

function validationTail(input) {
    var exp = /^[1-2][0-9][0-9]$/;
    return exp.test(input.value) && input.value !== "";
}

function validationState(input) {
    switch (input.value) {
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

function validationWeb(input) {
    var exp = /^([w][w][w][.][a-z 0-9]{3,30}[.][a-z]{2,7}[/][a-z 0-9]{3,30})$/;

    return exp.test(input.value) && input.value !== "";
}

function validationNamber(input) {
    var exp = /^6[0-9]{8}$/;

    return exp.test(input.value) && input.value !== "";
}

function runEffect(elemt, type){
    $("#" + elemt).show(type, 900);
}

function runEffectTag(elemt, type){
    $(elemt).show(type, 900);
}

function removeAllChilds(parent) {
    while (parent.hasChildNodes()) {
        parent.removeChild(parent.firstChild);
    }
}
