<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Problema 2 - EPD4</title>
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

        $palabras = ["arbol", "casa", "piso", "haber", "torre", "caballo", "alfil"];
        $palabrasMax= [
            "Suiza" => "ch",
            "España"=> "esp",
            "Alemania" => "ger",
            "Mejore" => "mj",
            "correcciones" => "corr"
        ];
        
        function comprobarFrase($frase){
            global $palabras;
            global $palabrasMax;
            $spliteado2 = explode(" ", $frase);
            $flagMin = count($spliteado2) - $_POST['minimo'];
            $flagMax = count($spliteado2) - $_POST['maximo'];
            $h = 0;
            $c = 0;
            echo "[". count($spliteado2)."]";
                if($flagMin<0){
                    echo "<span>Frase demasiado corta (se añaden palabras): ";
                    while($c<count($spliteado2)){
                        echo $spliteado2[$c]." ";
                        $c ++;
                        if($flagMin<0){
                            echo "<span class='min'>".$palabras[$h]."</span> ";
                            $h ++;
                        }
                    }
                    echo "</span><br>";
                    
                }else if($flagMax>0){
                    echo "<span>Frase demasiado larga (se abrevian palabras): ";
                    while($c<$_POST['maximo']){                        
                        if(array_key_exists($spliteado2[$c], $palabrasMax)){
                            echo "<span class='max'>".$palabrasMax[$spliteado2[$c]]."</span> ";                            
                        }else{
                            echo $spliteado2[$c]." ";
                        }
                        $c ++;
                    }
                    echo " ...</span><br>";
                }else{
                    echo "<span'>Frase demasiado correcta: ";
                    while($c<count($spliteado2)){
                        echo $spliteado2[$c]." ";
                        $c ++;
                    }
                    echo "</span><br>";
                }
                echo 'Frase inicial: ' .$frase.'<br>';
        }



        if (isset($_POST['envio'])) {
            if (!isset($_POST['info']))
                echo 'Error: No se ha mandado ningun texto<br />';
            else {
                $spliteado = split("[,.;\n]", $_POST['info']);
                for($i = 0; $i < count($spliteado); $i++){
                    comprobarFrase($spliteado[$i]);
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
