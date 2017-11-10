<?php
session_start();
echo "Origin: ".$_SESSION["origin"];
include 'functions.php';
require_once 'functions.php';

function updateLastAcess($user, $con) {
    // We are already logged in, so no need to create connection or validate values again
    $last_access = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET last_access='" . $last_access . "' WHERE user='" . $user."'";
    echo "<br />".$sql;
    $query = mysqli_query($con, $sql);
    if (!$query) {
        var_dump($query);
        mysqli_close($con);
        die("LAST_ACESS ERROR");
    }
}
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
            $user = mysqli_real_escape_string($con, $_POST['user']);
            $pwd = mysqli_real_escape_string($con, $_POST['password']);
            $sql = "SELECT * FROM users WHERE user='" . $user . "' AND password='" . $pwd . "'";
            echo $sql;
            $query = mysqli_query($con, $sql);
            if (!$query) {
                var_dump($query);
                mysqli_close($con);
                die("QUERY ERROR");
            } else if (mysqli_num_rows($query) == 1) {
                // If there is one result that means correct login
                $_SESSION["user"] = $user;
                updateLastAcess($user, $con);
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
                User: <input type="text" name="user" /><br />
                Password: <input type="password" name="password" /><br />
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