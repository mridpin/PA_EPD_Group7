<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login - P3 - EPD6</title>
    </head>
    <body>
        <h1>Acceso</h1>
                <?php
                include 'connectDB.php';
                session_start();
                if (isset($_GET['logout'])) {
                    //CERRAMOS LA SESION
                    $_SESSION['user'] = "";
                    echo "Sesion cerrada!";
                }

                if (isset($_POST['login'])) {
                    //Consultamos a la base de datos ya que se ha mandado un login
                    $enlace = connect();
                    mysqli_select_db($enlace, 'p3');
                    $res = mysqli_query($enlace, "SELECT usuario, contrasena, provincia FROM usuarios WHERE usuario = '" . mysql_real_escape_string($_POST['usuario']) . "'");
                    $fila = mysqli_fetch_assoc($res);
                    if (!($_POST['usuario']==$fila['usuario'])) {
                        echo "Usuario nuevo detectado: " . mysqli_error($enlace);
                        header("refresh:2; url=registro.php");
                    } else {
                        

                        //VERIFICAMOS EL HASH
                        if (password_verify($_POST['contrasena'], $fila['contrasena'])) {
                            session_start();
                            $_SESSION['usuario'] = $fila['usuario'];
                            $_SESSION['provincia'] = $fila['provincia'];
                            echo "Login correcto, redireccionando a la pagina principal...";
                            header("refresh:2; url=principal.php");
                        } else {
                            echo "Login incorrecto!!";
                           
                        }
                    }
                    //echo 'hola';
                     disconnect($enlace);
                    
                } else {
                    //Mostramos el form de login
                    echo "
                    <form method='post'>
                    <span>Nombre de usuario:</span><br>
                    <input type='text' name='usuario' value=''><br>
                    <span>Contrase&ntilde;a:</span><br>
                    <input type='password' name='contrasena' value=''><br>
                    <input type='submit' name='login' value='Log in'>"
                    . "</form>";
                }
                ?> 
    </body>
</html>
