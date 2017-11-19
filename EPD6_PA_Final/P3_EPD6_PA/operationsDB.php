<?php

//OPERACIONES TABLA LIGAS
function usuarios_list($enlace){
    $res = mysqli_query( $enlace , "SELECT * FROM usuarios");
    if (!$res){
            echo "Error creando la tabla: " . mysqli_error($enlace);
    }else{
        $array = array();
        while($row = mysqli_fetch_assoc($res)) {
            $array[] = $row;
        }
    }
    return $array;
}

function usuarios_create($enlace,$usuario, $contrasena, $email, $provincia){
    $sql = "INSERT INTO usuarios(usuario, contrasena, email, provincia) VALUES('". mysql_real_escape_string($usuario). "','". mysql_real_escape_string($contrasena). "','". mysql_real_escape_string($email) . "','". mysql_real_escape_string($provincia)."')";
    if (!mysqli_query($enlace , $sql)){
            echo "Error creando la tabla: " . mysqli_error($enlace);
    }
}

function usuarios_search($enlace, $string){
    $res = mysqli_query( $enlace , "SELECT * FROM usuarios WHERE usuario='". mysql_real_escape_string($string) . "'");
    if (!$res){
            echo "Error creando la tabla: " . mysqli_error($enlace);
    }else{
        $filas = mysqli_fetch_assoc($res);
    }
    return $filas;
}



