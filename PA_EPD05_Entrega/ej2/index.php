
<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1252">
        <title>
            PA EPD05 EJ3
        </title>
        <style type="text/css">
            .error_form{
                width: 100%;
                background-color: #F35656;
                color: white;
                overflow: auto;
                padding: 12px 10px;
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
            if (!isset($_POST['nombre']) || $_POST['nombre'] == "") {
                $errores[] = 'Indique su nombre';
            }
            if (!isset($_POST['email']) || $_POST['email'] == "") {
                $errores[] = 'Indique su email';
            }
            if (!isset($_POST['twitter']) || $_POST['twitter'] == "") {
                $errores[] = 'Indique una cuenta de twitter';
            }
            if (!isset($_POST['tlf-fijo']) || $_POST['tlf-fijo'] == "") {
                $errores[] = 'Indique su tel&eacute;fono fijo';
            }
            if (!isset($_POST['tlf-movil']) || $_POST['tlf-movil'] == "") {
                $errores[] = 'Indique su tel&eacute;fono movil';
            }
            if (!isset($_POST['info']) || $_POST['info'] == "") {
                $errores[] = 'Debe constar una descripci&oacute;n!';
            }
            if (!isset($errores)) {
                echo '<h2>Resumen</h2>';
                echo 'Nombre completo: ' . $_POST['nombre'] . ' <br>';
                echo 'Email: ' . $_POST['email'] . ' <br>';
                echo 'Twitter: @' . $_POST['nombre'] . ' <br>';
                echo 'Tel&eacute;fono fijo: ' . $_POST['tlf-fijo'] . ' <br>';
                echo 'Tel&eacute;fono m&oacute;vil: ' . $_POST['tlf-movil'] . ' <br>';
                echo 'Prov&iacute;ncia: ' . $_POST['provincia'] . ' <br>';
                echo 'Descripci&oacute;: ' . $_POST['info'] . ' <br>';
            }
        }
        if (!isset($_POST['envio']) || isset($errores)) {
            if (isset($errores)) {
                echo '<div class="error_form">'
                . '<ul>';
                foreach ($errores as $e) {
                    echo '<li>' . $e . '</li>';
                }
                echo '</ul>'
                . '</div>';
            }
            ?>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Introduce Nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ""; ?>"><br>
                <input type="email" name="email" placeholder="Introduce Email    user@domain.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>"><br>
                <input type="text" name="twitter" placeholder="twitter   @user" value="<?php echo isset($_POST['twitter']) ? $_POST['twitter'] : ""; ?>"><br>
                <input type="number" name="tlf-fijo" placeholder="Intoduce Telefono Fijo" value="<?php echo isset($_POST['tlf-fijo']) ? $_POST['tlf-fijo'] : ""; ?>"><br>
                <input type="number" name="tlf-movil" placeholder="Introduce Telefono Movil" value="<?php echo isset($_POST['tlf-movil']) ? $_POST['tlf-movil'] : ""; ?>"><br>
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
                <input type="submit" name="envio" value="Enviar" />
                <input type="reset" name="rest" value="Restaurar" />                  
            </form>
            <?php
        }
        ?>
    </body>
</html>
