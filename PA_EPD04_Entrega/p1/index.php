<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Problema 1 - EPD4</title>
        <style>
            .min{
                color: red;
            }
            .max{
                color: blue;
            }
        </style>
    </head>
    <body>
        <?php

        function comprobarFrase($frase) {
            $spliteado2 = explode(" ", $frase);
            $flag = 'none';
            if (count($spliteado2) < $_POST['minimo']) {
                $flag = 'min';
            } else if (count($spliteado2) > $_POST['maximo']) {
                $flag = 'max';
            }
            echo "[" . count($spliteado2) . "]";
            return $flag;
        }

        if (isset($_POST['envio'])) {
            if (!isset($_POST['info'])) {
                echo 'Error: No se ha mandado ningun texto<br />';
            } else {
                $spliteado = split("[,.;\n]", $_POST['info']);
                for ($i = 0; $i < count($spliteado); $i++) {
                    $res = comprobarFrase($spliteado[$i]);
                    if ($res == 'max') {
                        echo "<span class='max'>Frase demasiado larga: " . $spliteado[$i] . "</span><br> ";
                    } else if ($res == 'min') {
                        echo "<span class='min'>Frase demasiado corta: " . $spliteado[$i] . "</span><br> ";
                    } else {
                        echo "Frase correcta: " . $spliteado[$i] . "<br>";
                    }
                }
            }
        }

        if (!isset($_POST['envio'])) {
            ?>
            <h1> Env&iacute;a un archivo de texto </h1>
            <form method="post" enctype="multipart/form-data">
                <textarea name="info" id="info" style="height: 200px; width: 500px;" onclick="this.value = ''">Introduce las lineas...</textarea>
                <span>Minimo</span><select name="minimo">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <span>Maximo</span><select name="maximo">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <input type="submit" name="envio" value="Enviar" />
                <input type="reset" name="rest" value="Restaurar" />
            </form>
    <?php
}
?>
    </body>
</html>
