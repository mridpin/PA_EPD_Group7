<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Problema 3 - EPD6</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
    </head>
    <body>
        <?php
        include 'connectDB.php';
        include 'operationsDB.php';
        session_start();
        if (isset($_GET['logout'])) {
            //CERRAMOS LA SESION
            $_SESSION['user'] = "";
            echo "Sesion cerrada!";
            header("refresh:3; url=index.php");
        }
        if (isset($_POST['busquedaUni'])) {
            $enlace = connect();
            mysqli_select_db($enlace, 'p3');
            $res = mysqli_query($enlace, "SELECT nombre, autor, provincia FROM documentos WHERE provincia = '" . mysql_real_escape_string($_POST['provincia']) . "'");


            echo '<table>'
            . '<tr><th>Archivo</th><th>Usuario</th><th>Universidad</th></tr>';
            while ($fila = mysqli_fetch_array($res)) {
                echo '<tr>
                        <td><a href="archivos/' . $fila['nombre'] . '" target="_BLANK"/>' . $fila['nombre'] . '</td><td>' . $fila['autor'] . '</td><td>' . $fila['provincia'] . '</td>';
                echo "</tr>";
            }

            echo '</table>';
        } elseif (isset($_POST['busqueda'])) {
            $enlace = connect();
            mysqli_select_db($enlace, 'p3');
            $res = mysqli_query($enlace, "SELECT nombre, autor, provincia FROM documentos WHERE descripcion LIKE '%" . mysql_real_escape_string($_POST['clave']) . "%'");
            echo '<table>'
            . '<tr><th>Archivo</th><th>Usuario</th><th>Universidad</th></tr>';
            while ($fila = mysqli_fetch_array($res)) {
                echo '<tr>
                        <td><a href="archivos/' . $fila['nombre'] . '" target="_BLANK"/>' . $fila['nombre'] . '</td><td>' . $fila['autor'] . '</td><td>' . $fila['provincia'] . '</td>';
                echo "</tr>";
            }

            echo '</table>';
        } else if (isset($_POST['subirArchivo'])) {

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
            $hash_input = md5_file($_FILES["archivo"]["tmp_name"]);

            //if (!articuloExistente($hash_input)) {
            $ext = ".pdf";
            $name = $_POST['titulo'] . $ext;
            $path = "archivos/" . $name;

            $enlace = connect();
            $sql = "INSERT INTO documentos (nombre, horaSubida, descripcion, autor, provincia, codigoHash) VALUES('" . $name . "','" . time() . "','" . mysql_real_escape_string($_POST['descripcion']) . "','" . mysql_real_escape_string($_SESSION['usuario']) . "','" . mysql_real_escape_string($_SESSION['provincia']) . "','" . $hash_input . "')";
            if (!mysqli_query($enlace, $sql)) {
                echo "Error añadiendo el nuevo archivo: " . mysqli_error($enlace);
            } else {
                move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
            }
            disconnect($enlace);
        }
        //}





        $old_error_reporting = error_reporting(0);
        echo 'Usuario: ' . $_SESSION['usuario'];
            echo "<br><h3>Subir nuevo documento</h3>";
        echo '
    <form method="post" enctype="multipart/form-data">
        <span>T&iacute;tulo del documento: </span>
        <input type="text" name="titulo" value="' . $_POST['titulo'] . '"/><br>
        <span>Documento a introducir(Max: 5Mb, .pdf)</span><br>
        <input type="file" name="archivo"><br>
        <span>Descripción del art&iacute;culo: </span><br>
        <textarea name="descripcion" id="info" style="height: 200px; width: 500px;"></textarea>
        <input type="submit" name="subirArchivo" value="Subir archivo"/>
        <input type="hidden" name="name" value="' . $_POST['name'] . '">';
        echo '</form>';
        echo '
        <span>Busqueda por descripci&oacute;n</span>
         <form method="post" >
            <input type="text" name="clave" value=""><br>
            <input type="submit" name="busqueda" value="buscar">
         </form>';
        echo '
        <span>Busqueda por universidad</span>
         <form method="post" >
                <label for="Universidad">Universidad: </label>
                <select id="provincia" name="provincia">
                    <option value="Universidad de Sevilla">Universidad de Sevilla</option>
                    <option value="Universidad Pablo de Olavide">Universidad Pablo de Olavide</option>
                    <option value="Universidad de Huelva">Universidad de Huelva</option>
                    <option value="Universidad de Cordoba">Universidad de Cordoba</option>
                    <option value="Universidad de Malaga">Universidad de M&aacute;laga</option>
                    <option value="Universidad de Jaén">Universidad de Ja&eacute;n</option>
                    <option value="Universidad de Granada">Universidad de Granada</option>
                    <option value="Universidad de Almería">Universidad de Almer&iacute;a</option>
                    <option value="Universidad de Cádiz">Universidad de C&aacute;diz</option>
                    <option value="Universidad Internacional de Andalucía">Universidad de Andaluc&iacute;a</option>

                </select><br>
                <input type="submit" name="busquedaUni" value="Buscar">
         </form>';

        error_reporting($old_error_reporting);
       
            $enlace = connect();
            mysqli_select_db($enlace, 'p3');
            $res = mysqli_query($enlace, "SELECT nombre FROM documentos WHERE autor = '" . mysql_real_escape_string($_SESSION['usuario']) . "'");



            //VERIFICAMOS EL HASH
            echo '<ul>';
            while ($fila = mysqli_fetch_array($res)) {

                echo '<li><a href="archivos/' . $fila['nombre'] . '" target="_BLANK"/>' . $fila['nombre'] . '</li>';
            }
            echo '</ul>';

            disconnect($enlace);
            echo '
         <form method="Post" action="logout.php">
            <input type="submit" name="logout" value="logout">
         </form>';

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
?>    

