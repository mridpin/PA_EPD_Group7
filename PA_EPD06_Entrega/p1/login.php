<?php
session_start();
echo "Origin: " . $_SESSION["origin"];
include 'functions.php';
require_once 'functions.php';

function updateLastAcess($user, $link) {
    // We are already logged in, so no need to create connection or validate values again
    $last_access = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET last_access='" . $last_access . "' WHERE user='" . $user . "'";
    echo "<br />" . $sql;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        var_dump($result);
        mysqli_close($link);
        die("LAST_ACESS ERROR");
    }
}
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
                LOGIN: 
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
            $user = mysqli_real_escape_string($link, $_POST['user']);
            $hash = mysqli_real_escape_string($link, $_POST['password']);
            $sql = "SELECT * FROM users WHERE user='" . $user . "'";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                var_dump($result);
                mysqli_close($link);
                die("QUERY ERROR");
            } else if (mysqli_num_rows($result) > 0) {
                // If there is one+ result that means correct login
                $row = mysqli_fetch_array($result);
                if (password_verify($hash, $row["password"])) {
                    $_SESSION["user"] = $user;
                    updateLastAcess($user, $link);
                    mysqli_free_result($result);
                    mysqli_close($link);
                    header("Location: " . $_SESSION["origin"]);
                }
                // If user found but not password
                $error = "Incorrect user or password";
                mysqli_free_result($result);
                mysqli_close($link);
            } else if (mysqli_num_rows($result) == 0) {
                // If there is no results that means incorrect login
                $error = "Incorrect user or password";
                mysqli_free_result($result);
                mysqli_close($link);
            } else {
                var_dump($result);
                mysqli_free_result($result);
                mysqli_close($link);
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