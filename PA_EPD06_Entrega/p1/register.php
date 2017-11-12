<?php
session_start();
echo "Origin: ".$_SESSION["origin"];
include 'functions.php';
require_once 'functions.php';
?>

<html>
    <head>
        <title>PA EPD06 P1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1>
                PA EPD06 P1: AIRLINE INFORMATION SYSTEM                   
            </h1>
            <h2>
                REGISTER: 
            </h2>
        </header>
        <?php
        if (isset($_POST['submit'])) {
            $link = mysqli_connect("localhost", "root", "");
            if (!$link) {
                die("CONNECTION ERROR");
            }
            $sel_db = mysqli_select_db($link, "airlines");
            if (!$sel_db) {
                mysqli_close($link);
                die("SELECT ERROR");
            }
            $name = mysqli_real_escape_string($link, $_POST['name']);
            $user = mysqli_real_escape_string($link, $_POST['user']);
            $pwd = mysqli_real_escape_string($link, $_POST['password']);
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO users (name, user, password, last_access) VALUES ('" . $name . "', '" . $user . "', '" . $hash . "', '" . $date . "')";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                var_dump($result);
                mysqli_close($link);
                die("QUERY ERROR");
            } else {
                // If register successful
                $_SESSION["user"] = $user;
                mysqli_free_result($result);
                mysqli_close($link);
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