<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Problema 3</title>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
    </head>
    <body>
        

        <h1>Administrador de documentos</h1>
        <?php

        function comprobarUsuario($user, $pass) {

            if (file_exists("usuarios.txt")) {

                $f = fopen("usuarios.txt", "r");

                if ($f) {
                    flock($f, LOCK_SH);
                    $usuario = fgetcsv($f, 999, ";");

                    $flag = 0; //va a tomar 3 valores posibles, 0 si el usuario no existe, 1 si existe pero la contraseÃ±a no coincide y 2 si se acepta el log in
                    while (!feof($f) && $flag == 0) {

                        if (strcmp($user, $usuario[0]) == 0) {

                            if ($pass == $usuario[1]) {
                                $flag = 2;
                            } else {
                                $flag = 1;
                            }
                        }
                        $usuario = fgetcsv($f, 999, ";");
                    }
                    flock($f, LOCK_UN);
                    fclose($f);
                    return $flag;
                }
            } else {
                return 0;
            }
        }

        function crearUsuario($user, $pass) {
            if (isset($erroresRegistro)) {
                echo '<p style="color:red">Errores cometidos:</p>';
                echo '<ul style="color:red">';
                foreach ($errores as $e)
                    echo "<li>$e</li>";
                echo '</ul>';
            }
            ?>
            <form class="" action="#" method="post">
                <span>Nombre de usuario:</span><br>
                <input type="text" name="name" value="" ><br>
                <span>Contrase&ntilde;a</span><br>
                <input type="password" name="pass" value=""><br>
                <span>Correo electr&oacute;nico:</span><br>
                <input type="text" name="e-mail" value=""><br>
                <label for="Universidad">Universidad: </label>
                <select id="provincia" name="provincia">
                    <option value="Universidad de Sevilla">Universidad de Sevilla</option>
                    <option value="Universidad Pablo de Olavide">Universidad Pablo de Olavide</option>
                    <option value="Universidad de Huelva">Universidad de Huelva</option>
                    <option value="Universidad de Cordoba">Universidad de Cordoba</option>
                    <option value="Universidad de Malaga">Universidad de M&aacute;laga</option>
                    <option value="Universidad de JaÃ©n">Universidad de Ja&eacute;n</option>
                    <option value="Universidad de Granada">Universidad de Granada</option>
                    <option value="Universidad de AlmerÃ­a">Universidad de Almer&iacute;a</option>
                    <option value="Universidad de CÃ¡diz">Universidad de C&aacute;diz</option>
                    <option value="Universidad Internacional de AndalucÃ­a">Universidad de Andaluc&iacute;a</option>

                </select><br>
                <input type="submit" name="envioRegistro" value="Registrar">


            </form>
            <?php
        }

        if (isset($_POST['busquedaUni'])) {
            $archivosEncontrados = Array();
            $usuarios = Array();
            if (($f = fopen("documentos.txt", "r"))) {
                flock($f, LOCK_SH);
                $linea = fgetcsv($f, 999, ";");
                while (!feof($f)) {
                    if (strpos($linea[4], $_POST['provincia']) !== false) {
                        $archivosEncontrados[] = $linea[0];
                        $usuarios[] = $linea[3];
                        $universidades[] = $linea[4];
                    }
                    $linea = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            echo '<table >'
            . '<tr><th>Archivo</th><th>Usuario</th><th>Universidad</th></tr>';
            for ($i = 0; $i < count($usuarios); $i++) {
                echo "<tr>
                        <td><a href='archivos/" . $archivosEncontrados[$i] . "' target='_BLANK'/>$archivosEncontrados[$i]</td><td>$usuarios[$i]</td><td>$universidades[$i]</td>";
                echo "</tr>";
            }

            echo '</table>';
        } elseif (isset($_POST['busqueda'])) {
            $archivosEncontrados = Array();
            $usuarios = Array();
            $universidades = Array();
            if (($f = fopen("documentos.txt", "r"))) {
                flock($f, LOCK_SH);
                $linea = fgetcsv($f, 999, ";");
                while (!feof($f)) {
                    if (strpos($linea[2], $_POST['clave']) !== false) {
                        $archivosEncontrados[] = $linea[0];
                        $usuarios[] = $linea[3];
                        $universidades[] = $linea[4];
                    }
                    $linea = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            echo '<table >'
            . '<tr><th>Archivo</th><th>Usuario</th><th>Universidad</th></tr>';
            for ($i = 0; $i < count($usuarios); $i++) {
                echo "<tr>
                        <td><a href='archivos/" . $archivosEncontrados[$i] . "' target='_BLANK'/>$archivosEncontrados[$i]</td><td>$usuarios[$i]</td><td>$universidades[$i]</td>";
                echo "</tr>";
            }

            echo '</table>';
        } elseif (isset($_POST['envio'])) {
            $x = comprobarUsuario($_POST['name'], $_POST['pass']);
            //echo $x;
            if ($x == 0) {
                crearUsuario($_POST['name'], $_POST['pass']);
            } elseif ($x == 1) {
                echo 'Contrase&ntilde;a incorrecta';
            } else {
                imprimirFormularioArchivo();
            }
        } elseif (isset($_POST['envio3'])) {

            if ($_FILES['archivo']['error'] > 0) {
                $errorFile[] = "Error - " . $_FILES["archivo"]["error"];
            }
            if (!soloPDF($_FILES['archivo'])) {
                $errorsFile[] = "Formato " . $_FILES["archivo"]["type"] . " no soportado.";
            } elseif (!limiteTamanyo($_FILES['archivo'], 1024 * 1024 * 5)) {
                $errorsFile[] = "El tama&ntilde;o del fichero supera los 5MB.";
            }
            if (isset($errorsFile)) {
                echo '<div class="error_form">'
                . '<ul>';
                foreach ($errorsFile as $e) {
                    echo '<li>' . $e . '</li>';
                }
                echo '</ul>'
                . '</div>';
            }

            if (!isset($errorsFile)) {
                if (($g = fopen("usuarios.txt", "r"))) {
                    flock($g, LOCK_SH);
                    $usuario = fgetcsv($g, 999, ";");
                    $flag = FALSE;
                    while (!feof($g) && !$flag) {
                        if (strcmp($_POST['name'], $usuario[0]) == 0) {
                            $flag = true;
                        } else {
                            $usuario = fgetcsv($g, 999, ";");
                        }
                    }
                    flock($g, LOCK_UN);
                    fclose($g);
                }

                $hash_input = md5_file($_FILES["archivo"]["tmp_name"]);

                if (!articuloExistente($hash_input)) {
                    $ext = ".pdf";
                    $name = $_POST['titulo'] . $ext;
                    $path = "archivos/" . $name;

                    if (($f = fopen("documentos.txt", "a"))) {
                        flock($f, LOCK_EX);
                        fwrite($f, $name . ";" . time() . ";" . $_POST['descripcion'] . ";" . $_POST['name'] . ";" . $usuario[3] . ";" . $hash_input . "\n");
                        flock($f, LOCK_UN);
                        fclose($f);
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
                    }
                } else {
                    $errorsFile[] = "Este archivo ya estÃ¡ subido.";
                }
            }
            if (isset($errorsFile)) {
                echo '<div class="error_form">'
                . '<ul>';
                foreach ($errorsFile as $e) {
                    echo '<li>' . $e . '</li>';
                }
                echo '</ul>'
                . '</div>';
            }
            imprimirFormularioArchivo();
        } elseif (isset($_POST['envioRegistro'])) {
            if (comprobarUsuario($_POST['name'], $_POST['pass']) > 0) {
                $erroresRegistro[] = 'El nombre de usuario ya esta ocupado, eliga otro nombre de usuario.';
                crearUsuario($_POST['name'], $_POST['pass']);
            } else {
                echo '<h2>Usuario creado</h2>';
                echo 'Usuario: ' . $_POST['name'] . '<br/>';
                echo 'Contrase&ntilde;a: ' . $_POST['pass'] . '<br/>';
                echo 'E-mail: ' . $_POST['e-mail'] . '<br/>';
                echo 'Universidad: ' . $_POST['provincia'] . '<br/>';
                $f = fopen("usuarios.txt", "a");
                if ($f) {
                    //flock($f, LOCK_SH);
                    echo $_POST['name'] . ";" . $_POST['pass'] . ";" . $_POST['e-mail'] . ";" . $_POST['provincia'] . "\n";
                    fwrite($f, $_POST['name'] . ";" . $_POST['pass'] . ";" . $_POST['e-mail'] . ";" . $_POST['provincia'] . "\n");
                    //flock($f, LOCK_UN);
                    fclose($f);
                }
                header( "refresh:2;url=index.php" );
            }
        } elseif (!isset($_POST['envio']) || isset($errores)) {
            ?>
            <form method="post">
                <span>Nombre de usuario:</span><br>
                <input type="text" name="name" value=""><br>
                <span>Contrase&ntilde;a:</span><br>
                <input type="password" name="pass" value=""><br>
                <input type="submit" name="envio" value="Log in">
            </form>
            <?php
        }
        ?>
            
    </body>
</html>

<?php

function soloPDF($fichero) {
    $soportado = Array("application/pdf", "application/x-download");
    if (array_search($fichero['type'], $soportado) === false) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function limiteTamanyo($fichero, $limite) {
    return $fichero['size'] <= $limite;
}

function articuloExistente($hash_input) {
    $flag = FALSE;
    if (file_exists("documentos.txt")) {
        if (($f = fopen("documentos.txt", "r"))) {
            if (filesize("documentos.txt") > 0) {
                flock($f, LOCK_SH);
                $linea = fgetcsv($f, 999, ";");
                while (!$flag && !feof($f)) {
                    if ($linea != "") {
                        if ($hash_input == $linea[5]) {
                            $flag = true;
                        }
                    }
                    $linea = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
            }
            fclose($f);
        }
    }
    return $flag;
}

function imprimirFormularioArchivo() {
    $old_error_reporting = error_reporting(0);
    echo "<h2 id='user'>Usuario:" .$_POST['name'] ."</h2> ";
    echo "<br><h3>Subir nuevo documento</h3>";
    echo '
    <form method="post" enctype="multipart/form-data">
        <span>T&iacute;tulo del documento: </span>
        <input type="text" name="titulo" value="' . $_POST['titulo'] . '"/><br>
        <span>Documento a introducir(Max: 5Mb, .pdf)</span><br>
        <input type="file" name="archivo"><br>
        <span>Descripci&oacute;n del art&iacute;culo: </span><br>
        <textarea name="descripcion" id="info"></textarea>
        <input type="submit" name="envio3" value="Subir archivo"/>
        <input type="hidden" name="name" value="' . $_POST['name'] . '">';
    echo '</form>';
    echo '
        <br><br><h3>Busqueda por descripci&oacute;n</h3>
         <form method="post" >
            <input type="text" name="clave" value=""><br>
            <input type="submit" name="busqueda" value="buscar">
         </form>';
    echo '
        <br><br><h3>Busqueda por universidad</h3>
         <form method="post" >
                <label for="Universidad">Universidad: </label>
                <select id="provincia" name="provincia">
                    <option value="Universidad de Sevilla">Universidad de Sevilla</option>
                    <option value="Universidad Pablo de Olavide">Universidad Pablo de Olavide</option>
                    <option value="Universidad de Huelva">Universidad de Huelva</option>
                    <option value="Universidad de Cordoba">Universidad de Cordoba</option>
                    <option value="Universidad de Malaga">Universidad de M&aacute;laga</option>
                    <option value="Universidad de JaÃ©n">Universidad de Ja&eacute;n</option>
                    <option value="Universidad de Granada">Universidad de Granada</option>
                    <option value="Universidad de AlmerÃ­a">Universidad de Almer&iacute;a</option>
                    <option value="Universidad de CÃ¡diz">Universidad de C&aacute;diz</option>
                    <option value="Universidad Internacional de AndalucÃ­a">Universidad de Andaluc&iacute;a</option>

                </select><br>
                <input type="submit" name="busquedaUni" value="Buscar">
         </form>';

    error_reporting($old_error_reporting);
    if (file_exists("documentos.txt")) {
        $f = fopen("documentos.txt", "r");
        if ($f) {
            flock($f, LOCK_SH);
            $archivo = fgetcsv($f, 999, ";");
            echo "<br><br><h3>Mis archivos</h3>";
            echo '<ul id="listaArchivos">';
            while (!feof($f)) {
                if (strcmp($_POST['name'], $archivo[3]) == 0) {
                    echo "<li><a href='archivos/$archivo[0]' target='_BLANK'/>$archivo[0]</li>";
                }
                $archivo = fgetcsv($f, 999, ";");
            }
            echo '</ul>';
            flock($f, LOCK_UN);
            fclose($f);
        }
    }
}
?>