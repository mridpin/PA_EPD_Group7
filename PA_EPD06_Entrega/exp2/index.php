
<html>
    <body>
        <?php
        if (isset($_POST['submit'])) {
            $con = mysqli_connect("localhost", "root", "");
            if (!$con) {
                die("ERROR CONNECT");
            }
            $sel_db = mysqli_select_db($con, "Practica");
            if (!$sel_db) {
                mysqli_close($con);
                die("ERROR SELECT");
            }
            $name = mysqli_real_escape_string($con, $_POST['username']);
            $pwd = mysqli_real_escape_string($con, $_POST['userpasswd']);
            echo $pwd;
            $query = mysqli_query($con, "SELECT * FROM Users WHERE name='".$name."' AND pwd='".$pwd."'");
            if (!$query) {
                var_dump($query);
                mysqli_close($con);
                die("ERROR QUERY");
            }
            echo "<table border='1'> <tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>PWD</th></tr>";
            while ($row = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['pwd'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            mysqli_free_result($query);
            mysqli_close($con);
        }

        if (!isset($_POST['submit']) || isset($error)) {
            if (isset($error)) {
                echo $error;
            }
            ?>
            <form method="post" action=".">
                <input type="text" name="username" />
                <input type="password" name="userpasswd" />
                <input type="submit" name ="submit" />
            </form>
            <?php
        }
        ?>
    </body>
</html>


