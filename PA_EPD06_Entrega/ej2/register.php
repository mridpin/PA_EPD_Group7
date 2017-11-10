<?php
session_start();
echo "Origin: ".$_SESSION["origin"];
include 'functions.php';
require_once 'functions.php';
?>

<html>
    <head>
        <title>PA EPD06 EJ1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1>
                PA EPD06 EJ1: AIRLINE INFORMATION SYSTEM                   
            </h1>
            <h2>
                REGISTER: 
            </h2>
        </header>
        <?php
        if (isset($_POST['submit'])) {
            $con = mysqli_connect("localhost", "root", "");
            if (!$con) {
                die("CONNECTION ERROR");
            }
            $sel_db = mysqli_select_db($con, "airlines");
            if (!$sel_db) {
                mysqli_close($con);
                die("SELECT ERROR");
            }
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $user = mysqli_real_escape_string($con, $_POST['user']);
            $pwd = mysqli_real_escape_string($con, $_POST['password']);
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO users (name, user, password, last_access) VALUES ('" . $name . "', '" . $user . "', '" . $pwd . "', '" . $date . "')";
            $query = mysqli_query($con, $sql);
            if (!$query) {
                var_dump($query);
                mysqli_close($con);
                die("QUERY ERROR");
            } else {
                // If register successful
                $_SESSION["user"] = $user;
                mysqli_free_result($query);
                mysqli_close($con);
                header("Location: " . $_SESSION["origin"]);
            }
        }

        if (!isset($_POST['submit']) || isset($error)) {
            if (isset($error)) {
                printErrorMessage($error);
            }
            ?>
            <form method="post" action="register.php">
                Name: <input type="text" name="name" /><br />
                User: <input type="text" name="user" /><br />
                Password: <input type="password" name="password" /><br />
                <input type="submit" name ="submit" value="Register"/>
            </form>
            <?php
        }
        ?>
    </body>
</html>