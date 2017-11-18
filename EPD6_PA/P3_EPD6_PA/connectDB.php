
<?php

    function connect(){
        $enlace =  mysqli_connect('localhost', 'root', 'root');
        if (!$enlace) {
            die('No pudo conectarse: ' . mysqli_error());
        }
        //SELEECIONA LA BASE DE DATOS Y EN CASO DE NO EXISTIR LA CREA
        prepareDB($enlace);
        return $enlace;
    }

    function disconnect($enlace){
        mysqli_close($enlace);
    }
    
    function prepareDB($enlace){
        if (mysqli_select_db($enlace,'p3')==0) {
            mysqli_query( $enlace , "CREATE DATABASE p3");
            mysqli_select_db($enlace, 'p3');
            
            $sql = "CREATE TABLE usuarios (usuario VARCHAR(30) NOT NULL PRIMARY KEY, contrasena VARCHAR(100), email VARCHAR(100), provincia VARCHAR(100));";
            if (!mysqli_query($enlace , $sql)){
                echo "Error creando la tabla: " . mysqli_error($enlace);
            }
            
            $sql = "CREATE TABLE documentos (nombre VARCHAR(30), horaSubida VARCHAR(100), descripcion VARCHAR(300), autor VARCHAR(30), provincia VARCHAR(100), codigoHash VARCHAR(100) NOT NULL PRIMARY KEY );";
            if (!mysqli_query($enlace , $sql)){
                echo "Error creando la tabla: " . mysqli_error($enlace);
            }

        }
    }
 ?>
