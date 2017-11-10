<?php
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
                LOGIN: 
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
            /* $name = mysqli_real_escape_string($con, $_POST['user']);
              $pwd = mysqli_real_escape_string($con, $_POST['password']); */
            $name = $_POST['user'];
            $pwd = $_POST['password'];
            $query = mysqli_query($con, "SELECT * FROM users WHERE name='" . $name . "' AND password='" . $pwd . "'");
            if (!$query) {
                var_dump($query);
                mysqli_close($con);
                die("QUERY ERROR");
            } else if (mysqli_num_rows($query) == 1) {
                // If there is one result that means correct login
                $_SESSION["user"] = $query;
                mysqli_free_result($query);
                mysqli_close($con);
                header("Location: " . $_SESSION["origin"]);
            } else if (mysqli_num_rows($query) == 0) {
                // If there is no results that means incorrect login
                $error = "Incorrect user or password";
                mysqli_free_result($query);
                mysqli_close($con);
            } else {
                var_dump($query);
                mysqli_free_result($query);
                mysqli_close($con);
                die("SOMETHING ELSE WENT WRONG!");
            }
        }

        if (!isset($_POST['submit']) || isset($error)) {
            if (isset($error)) {
                printErrorMessage($error);
            }
            ?>
            <form method="post" action="login.php">
                <input type="text" name="user" />
                <input type="password" name="password" />
                <input type="submit" name ="submit" />
            </form>
            <form method="post" action="register.php">
                <input type="submit" name="register" value="Register"/>
            </form>
            <?php
        }
        ?>
    </body>
</html>