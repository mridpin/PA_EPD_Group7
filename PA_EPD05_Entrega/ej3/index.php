<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

function correctNameFormat($name) {
    /* returns true if name format is correct, false if it doens't exists or it isnt */
    $res = isset($name) && $name !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^[[:upper:]]{1} -> Primer caracter es mayuscula
         *      [\s\p{L}-]+ -> Resto son espacios, letras unicode (incluye acentos) o guiones "-".
         *      /u -> Indica que hay caracteres unicode      
         */
        $res = $res && preg_match('/^[[:upper:]]{1}[\s\p{L}-]+$/u', $name);
    }
    return $res;
}

function correctEmailFormat($email) {
    /* returns true if email format is correct, false if it doens't exists or it isnt */
    $res = isset($email) && $email !== "";
    if ($res === TRUE) {
        $res = $res && filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    return $res;
}

function correctTwitterUserFormat($user) {
    /* returns true if email format is correct, false if it doens't exists or it isnt */
    $res = isset($user) && $user !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^@ -> Starts with @
         *      [^\s]+ -> Any character except whitespace " "
         */
        $res = $res && preg_match('/^@[^\s]+$/', $user);
    }
    return $res;
}

function correctPhoneFormat($phone) {
    /* returns true if phone format is correct, false if it doens't exists or it isnt */
    $res = isset($phone) && $phone !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^9 -> Starts with 9
         *      [[:digit:]]{8} -> Eight more digits
         */
        $res = $res && preg_match('/^9[[:digit:]]{8}$/', $phone);
    }
    return $res;
}

function correctMobileFormat($mobile) {
    /* returns true if mobile format is correct, false if it doens't exists or it isnt */
    $res = isset($mobile) && $mobile !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^6 -> Starts with 6
         *      [[:digit:]]{8} -> Eight more digits
         */
        $res = $res && preg_match('/^6[[:digit:]]{8}$/', $mobile);
    }
    return $res;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>
            PA EPD05 EJ3
        </title>
        <style type="text/css">
            .error_form{
                width: 100%;
                background-color: #F35656;
                color: white;
                overflow: auto;
                padding: 2px 1px;
                margin-top: 20px;
                box-sizing: border-box;
                border: none;
                border-radius: 4px;
            }
            .error_form li{
                list-style-type: square;
            }
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <h1> Rutas de senderismo por Andaluc&iacute;a </h1>
        <?php
        if (isset($_POST['envio'])) {
            $name = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $user = filter_input(INPUT_POST, "twitter", FILTER_SANITIZE_STRING);
            $phone = filter_input(INPUT_POST, "tlf-fijo", FILTER_SANITIZE_NUMBER_INT);
            $mobile = filter_input(INPUT_POST, "tlf-movil", FILTER_SANITIZE_NUMBER_INT);
            if (!correctNameFormat($name)) {
                $errores['nombre'] = "Nombre no v&aacute;lido o no existe: Ejemplo de nombre v&aacute;lido: Manuel Ridao [solo car&aacute;cteres alfab&eacute;ticos y espacios, primera letra may&uacute;scula]";
            }
            if (!correctEmailFormat($email)) {
                $errores['email'] = "Email no v&aacute;lido o no existe: Ejemplo de email v&aacute;lido: example@example.com";
            }
            if (!correctTwitterUserFormat($user)) {
                $errores['twitter'] = "Twitter no v&aacute;lido o no existe: Ejemplo de twitter v&aacute;lido: @usuario";
            }
            if (!correctPhoneFormat($phone)) {
                $errores['phone'] = "Tel&eacute;fono no v&aacute;lido o no existe: Ejemplo de Tel&eacute;fono v&aacute;lido: 999999999 [9 cifras comenzando por 9]";
            }
            if (!correctMobileFormat($mobile)) {
                $errores['mobile'] = "M&oacute;vil no v&aacute;lido o no existe: Ejemplo de M&oacute;vil v&aacute;lido: 666666666 [9 cifras comenzando por 6]";
            }
            if (!isset($_POST['info']) || $_POST['info'] == "") {
                $errores['info'] = 'Debe constar una descripci&oacute;n!';
            }
            if (!isset($errores)) {
                echo '<h2>Resumen</h2>';
                echo 'Nombre completo: ' . $_POST['nombre'] . ' <br>';
                echo 'Email: ' . $_POST['email'] . ' <br>';
                echo 'Twitter: @' . $_POST['twitter'] . ' <br>';
                echo 'Tel&eacute;fono fijo: ' . $_POST['tlf-fijo'] . ' <br>';
                echo 'Tel&eacute;fono m&oacute;vil: ' . $_POST['tlf-movil'] . ' <br>';
                echo 'Prov&iacute;ncia: ' . $_POST['provincia'] . ' <br>';
                echo 'Descripci&oacute;: ' . $_POST['info'] . ' <br>';
            }
        }
        if (!isset($_POST['envio']) || isset($errores)) {
            ?>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Introduce Nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ""; ?>">
                <?php echo (isset($errores['nombre']) ? "<span class='error_form'>" . $errores['nombre'] . "</span>" : ""); ?><br>

                <input type="text" name="email" placeholder="Introduce Email    user@domain.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>">
                <?php echo (isset($errores['email']) ? "<span class='error_form'>" . $errores['email'] . "</span>" : ""); ?><br>

                <input type="text" name="twitter" placeholder="twitter   @user" value="<?php echo isset($_POST['twitter']) ? $_POST['twitter'] : ""; ?>">
                <?php echo (isset($errores['twitter']) ? "<span class='error_form'>" . $errores['twitter'] . "</span>" : ""); ?><br>

                <input type="text" name="tlf-fijo" placeholder="Intoduce Telefono Fijo" value="<?php echo isset($_POST['tlf-fijo']) ? $_POST['tlf-fijo'] : ""; ?>">
                <?php echo (isset($errores['phone']) ? "<span class='error_form'>" . $errores['phone'] . "</span>" : ""); ?><br>

                <input type="text" name="tlf-movil" placeholder="Introduce Telefono Movil" value="<?php echo isset($_POST['tlf-movil']) ? $_POST['tlf-movil'] : ""; ?>">
                <?php echo (isset($errores['mobile']) ? "<span class='error_form'>" . $errores['mobile'] . "</span>" : ""); ?><br>

                <label for="provincia">Provincia: </label>
                <select id="provincia" name="provincia">
                    <option value="Sevilla" selected>Sevilla</option>
                    <option value="Cadiz">C&aacute;diz</option>
                    <option value="Huelva">Huelva</option>
                    <option value="Cordoba">C&oacute;rdoba</option>
                    <option value="Malaga">M&aacute;laga</option>
                    <option value="Jaen">Ja&eacute;n</option>
                    <option value="Granada">Granada</option>
                    <option value="Almeria">Almer&iacute;a</option>
                </select><br>

                <label>Descripci&oacute;n de la ruta: </label><br>                
                <textarea name="info" id="info" onClick="this.value = '';">Descripci&oacute;n</textarea>
                <?php echo (isset($errores['info']) ? "<span class='error_form'>" . $errores['info'] . "</span>" : ""); ?><br>

                <input type="submit" name="envio" value="Enviar" />
                <input type="reset" name="rest" value="Restaurar" />                  
            </form>
            <?php
        }
        ?>
    </body>
</html>
