<!DOCTYPE html>
<html>
    <head>
    <head>
        <title>Problema 3 - EPD6 - Grupo 5</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
    </head>
    <body>
        <?php
        include 'connectDB.php';
        include 'operationsDB.php';
        session_start();
        
            //Escritura del documento
            if (isset($_POST['registro'])) {
                $enlace = connect();

                $sql = "INSERT INTO usuarios(usuario, contrasena, email, provincia) VALUES('" . mysql_real_escape_string($_POST['usuario']) . "','" . password_hash($_POST['contrasena'], PASSWORD_DEFAULT) . "','" . mysql_real_escape_string($_POST['email']) . "','" . mysql_real_escape_string($_POST['provincia']) . "')";

                if (!mysqli_query($enlace, $sql)) {
                    echo "Error añadiendo el nuevo usuario: " . mysqli_error($enlace);
                } else {
                    $_SESSION['user'] = $_POST['usuario'];
                    echo "Registro correcto, redireccionando a la pagina principal...";
                    header("refresh:3; url=principal.php");
                }
                disconnect($enlace);
            }
            //Formulario Inicial
            else {

                if (isset($erroresRegistro)) {
                    echo '<p style="color:red">Errores cometidos:</p>';
                    echo '<ul style="color:red">';
                    foreach ($errores as $e)
                        echo "<li>$e</li>";
                    echo '</ul>';
                }
                ?>
                <form class="" action="#" method="post">
                    <span>Nombre de usuario:</span><br>
                    <input type="text" name="usuario" value="" ><br>
                    <span>Contrase&ntilde;a</span><br>
                    <input type="password" name="contrasena" value=""><br>
                    <span>Correo electr&oacute;nico:</span><br>
                    <input type="text" name="email" value=""><br>
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
                    <input type="submit" name="registro" value="Registrar">


                </form>
                <?php
            }
        
        ?>
</body>
</html>
