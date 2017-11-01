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
        
        
        function getImage($tags,$filename)
        {
            $count=1; //Utilizado para controlar la ,
            $url="https://source.unsplash.com/featured/";
            $auxi="$";
            foreach($tags as $aux)
            {
                $auxi.="<".$aux.">";
                if($count!=sizeof($tags))
                {
                    $auxi.=",";
                }
                $count++;
            }
            $url.= urlencode($auxi); //El resto de contenido de la url debe ser codificado
           file_put_contents("$filename", fopen("$url", 'r')); 
        }
        
        function createTable()
        {
            
        }




        // Parte superior de la pagina
        // Tenemos que comprobar si venimos de un formulario
        if(isset($_POST["checkboxes"]) || isset($_POST["file"])) //Hemos venido de un formulario
        {
            if(isset($_POST["tag"])) //Si nos han introducido datos por checkbox
            {
                getImage($_POST["tag"],"test.jpg");
            }
            
        }
        ?>
        <!Parte inferior de la pagina>
        <h3>Seleccione o suba un fichero, con las categorias de la foto que desea ver:</h3>
        <br>
        <form action="index.php" method="POST" enctype="multipart/form-data">
         Nature<input type="checkbox" name="tag[]" value="nature">
            &nbsp;
            Lake<input type="checkbox" name="tag[]" value="lake">
            &nbsp;
            Mountain<input type="checkbox" name="tag[]" value="mountain">
            &nbsp;
            Forest<input type="checkbox" name="tag[]" value="forest">
            &nbsp;
            Dog<input type="checkbox" name="tag[]" value="dog">
            &nbsp;
            Car<input type="checkbox" name="tag[]" value="car">
            &nbsp;
            Girl<input type="checkbox" name="tag[]" value="girl">
            &nbsp;
            Agent<input type="checkbox" name="tag[]" value="Agent">
            <input type="file" name="archivo">
            <br>
            <input type="submit" name="checkboxes" value="Enviar Selecciones">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="file" value="Enviar Archivo">
        </form>
    </body>
</html>
