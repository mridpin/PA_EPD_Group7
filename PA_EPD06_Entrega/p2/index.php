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
        
        function createConnection() //Establece conexion con la base de datos
        {
            $con = new mysqli("localhost","root","");
            if(!$con)
                die("No hay conexion con la SGBD");
            $db = mysqli_select_db($con,"p2");
            if(!$db)
                die("No se ha encontrado la BD");
            return $con;
        }
        
        
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
            //No saneamos las entradas ya que no van a presentar ningun peligro porque accedemos a una url
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
            writeToDB($tags, $filename);
        }
        
        function writeToDB($tags,$filename) //Escribimos en la base de datos las categorias de la foto y el nombre del archivo
        {
            $con = createConnection();
            $tags = mysqli_real_escape_string($con,$tags); //Saneamos ambas entradas
            $filename = mysqli_real_escape_string($con,$filename);
            $query = ("INSERT INTO server_images (tags,fname) VALUES ('".$tags."', '".$filename."')");
            $res = mysqli_query($con, $query);
            if(!$res)
            {
                echo("Error ".mysqli_error($con));
            }
            mysqli_close($con); //Cerramos la conexion con la base de datos
            
        }
        
        function readFromDB()
        {
            $data; //Matriz de 2 dimensiones donde el primero son los tags con la fecha de obtencion  y el segundo el nombre de la foto
            $i=0;
            $con = createConnection();
            $query = ("SELECT * FROM server_images");
            $res=mysqli_query($con, $query);
            if(!mysqli_num_rows($res)) //Si la tabla esta vacia
            {
                $data="No hay imagenes cargadas";
            }
            else
            {
                while($line = mysqli_fetch_array($res))
                    {
                        $data[$i][0] = $line['tags'];
                        $data[$i][1] = $line['fname'];
                        $i++;
                    }     
            }
            mysqli_close($con);
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
        echo createTable(readFromDB()); //Intentamos imprimir la tabla
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
