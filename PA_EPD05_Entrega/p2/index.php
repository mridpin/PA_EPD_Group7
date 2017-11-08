<!DOCTYPE html>
<!--
Grupo 7
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        function getDateFormat() //Formato correcto para los archivos
        {
            $now = new DateTime();
         return $now->format('Y-m-d_H-i-s');
        }

        function getImage($raw_tags, $filename) {
            $count = 1; //Utilizado para controlar la ,
            $url = "https://source.unsplash.com/featured/";
            $auxi = "$";
            $tags=""; //Para escribir en el fichero
            foreach ($raw_tags as $aux) {
                $auxi .= "<" . $aux . ">";
                $tags.=$aux;
                if ($count != sizeof($raw_tags)) {
                    $auxi .= ",";
                    $tags.=",";
                }
                $count++;
            }
            $url .= urlencode($auxi); //El resto de contenido de la url debe ser codificado
            $filename.='.jpg';
            file_put_contents("$filename", fopen("$url", 'r'));
            writeToFile($tags, $filename);
        }
        
        function writeToFile($tags,$filename) //Escribimos en un fichero las categorias de la foto y el nombre del archivo
        {
            //Esta funcion hace que abramos el fichero (si no existe lo crea), escribamos en el fichero con un lock y finalmente cierre el fichero
            file_put_contents($GLOBALS['serverFile'],$tags. "\t" . $filename . "\r\n", FILE_APPEND | LOCK_EX);
            
        }
        
        function readFromFile()
        {
            $data; //Matriz de 2 dimensiones donde el primero son los tags con la fecha de obtencion  y el segundo el nombre de la foto
            $i=0;
            if(file_exists($GLOBALS['serverFile']))
            {
                $f = fopen($GLOBALS['serverFile'],'r');             
                    flock($f,LOCK_SH); //Bloqueamos la escritura del fichero
                    while(($line = fgets($f)) !== false)
                    {
                        $line = rtrim($line, "\r\n");
                        $rawData = explode("\t", $line); //La primera posicion tendra los tags y la segunda el nombre de la foto
                        $data[$i][0] = $rawData[0];
                        $data[$i][1] = $rawData[1];
                        $i++;
                    }
                    flock($f,LOCK_UN);
                    fclose($f);              
            }
            else
            {
                $data="No hay imagenes cargadas";
            }
            
            return $data;
        }

        function processData($line) {
            $alphabet = range('A', 'Z');

            $rawData = explode(";", $line); //Separamos todas las peticiones de imagenes

            for ($i = 0; $i < sizeof($rawData); $i++) { //Para cada peticion vamos a coger su imagen
                $filename= getDateFormat();
                getImage(explode(",", $rawData[$i]),$filename.='-'.$alphabet[$i]); //Para obtener las letras correctamente.
            }
        }

        function createTable($data) {
            if(is_array($data)==TRUE)
            {
                $result="<h1 align='center'> Tus imagenes</h1>"
                        . "<br>"
                        . "<table align='center'>";
                for($i=0;$i<sizeof($data);$i++)
                {
                    $result.="<tr>"
                                ."<td>"
                                    ."<figure>"
                                        ."<img src=".$data[$i][1]." width=200>"
                                        ."<figcaption>".trim($data[$i][1],".jpg")." - ".$data[$i][0]." </figcaption>"
                                    ."</figure>"
                                . "</td>"
                            . "</tr>";
                }
                $result.="</table>";
            }
            else
                $result="<strong>Todavia no tienes ninguna imagen</strong>";
            
            return $result;
            
        }
        $serverFile='server_images.txt';
        // Parte superior de la pagina
        // Tenemos que comprobar si venimos de un formulario
        if (isset($_POST["checkboxes"]) || isset($_POST["file"])) { //Hemos venido de un formulario
            
            if (isset($_POST["tag"])) { //Si nos han introducido datos por checkbox
                
                getImage($_POST["tag"], getDateFormat());
                
            } else if ($_FILES["archivo"]['type']=='text/plain') { //Se ha pulsado el boton de enviar fichero y comprobamos que es un fichero de texto
                $line=file_get_contents($_FILES["archivo"]['tmp_name']);
                if(strlen($line)<=200) //Si no se superan los 200 caracteres
                {
                     processData($line); //Procesamos el contenido del fichero subido
                }
                else
                    echo "ERROR: No se pueden superar los 200 caracteres por archivo";
            }
            else
                echo "ERROR: El archivo debe ser un fichero de texto";
        }
        echo createTable(readFromFile()); //Intentamos imprimir la tabla
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
        Agent<input type="checkbox" name="tag[]" value="agent">
        <input type="file" name="archivo">
        <br>
        <input type="submit" name="checkboxes" value="Enviar Selecciones">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="file" value="Enviar Archivo">
    </form>
</body>
</html>
