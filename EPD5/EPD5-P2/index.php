<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // Tenemos que comprobar si venimos de un formulario
        ?>
        <h3>Seleccione o suba un fichero, con las categorias de la foto que desea ver:</h3>
        <br>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            Nature<input type="checkbox" name="nature">
            &nbsp;
            Lake<input type="checkbox" name="lake">
            &nbsp;
            Mountain<input type="checkbox" name="mountain">
            &nbsp;
            Forest<input type="checkbox" name="forest">
            &nbsp;
            Dog<input type="checkbox" name="dog">
            &nbsp;
            Car<input type="checkbox" name="car">
            &nbsp;
            Girl<input type="checkbox" name="girl">
            &nbsp;
            Agent<input type="checkbox" name="Agent">
            <input type="file" name="archivo"/>
        </form>
    </body>
</html>
