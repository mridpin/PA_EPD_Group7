<!DOCTYPE html>
<?php
session_start();
include 'functions.php';
require_once 'functions.php';

/* If the user isn't logged in, send him to the login page and save where he came from */
if (!isLoggedIn("user")) {
    $_SESSION["origin"] = $_SERVER["PHP_SELF"];
    header("Location: login.php");
}

/* Functions:
 *  provideAirlineNameAndNumberOfDestinations($nameError, $destError): Checks if the supplied values have errors. Then prints the form
 *  provideAirlineDestinations(): Reads the available cities from a table, then presents a form to select as many destinations
 *      as specified in the method above from the cities in the table
 *  writeAirlineToDatabase(): creates the output data table from the data collected in the two previous methods so that the rest of the site can use them
 */

function provideAirlineNameAndNumberOfDestinations($nameError, $destError) {

    printErrorMessage($nameError);
    printErrorMessage($destError);

    echo "<form method='get' action='newAirline.php'>";
    echo "Airline name: <input type='text' name='airlineName' /> <br />";
    echo "Number of destinations: <input type='text' name='numberOfDestinations' /> <br />";
    echo "<input type='submit' name='airlineSubmitted' />";
    echo "</form>";
}

function provideAirlineDestinations($host, $user, $pass, $database) {
    /* Step 1: read possible destinations from database */
    $link = connectToDatabase($host, $user, $pass, $database);
    $sql = "SELECT * FROM cities";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $availableCitiesList = [];
        while ($row = mysqli_fetch_array($result)) {
            $availableCitiesList[] = $row["city"];
        }
        mysqli_free_result($result);
        mysqli_close($link);
    } else {
        mysqli_close($link);
        die("QUERY ERROR");
    }

    /* Step 2: print a list of selectables with the destinations in the list */
    echo "<form method='get' action 'newAirline.php' id='destForm'>";
    echo "Airline: " . $_GET["airlineName"] . ": <br /> Please provide a city for each destination with the dropdown menus: <br />";
    for ($i = 0; $i < $_GET["numberOfDestinations"]; $i++) {
        $name = "destination[" . $i . "]";
        echo "Destination $i: <select name=\"$name\">";
        foreach ($availableCitiesList as $city) {
            echo "<option value=\"$city\">$city</option>";
        }
        echo "</select> <br />";
    }
    // Save the values from the previous form step as session variables to use in next form step
    $_SESSION["airlineName"] = $_GET["airlineName"];
    $_SESSION["numberOfDestinations"] = $_GET["numberOfDestinations"]; 
    echo "<input type='submit' name='airlineCityDestinationsSubmitted' />";   
    echo "</form>";
}

function writeAirlineToDatabase($host, $user, $pass, $database) {
    $error = false;
    /* Step 1: write code and name to table "airlines" */
    $link = connectToDatabase($host, $user, $pass, $database);
    $airlineNames = [];
    $newAirlineCode = "";
    $name = mysqli_real_escape_string($link, $_SESSION["airlineName"]);
    $sql = "INSERT INTO airlines (name) VALUES ('" . $name . "')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        var_dump($result);
        mysqli_close($link);
        $error = TRUE;
        die("QUERY 1 ERROR");
    }

    /* Step 2: Write code and destintions to table "destinations" */
    if (!$error) { // This prevents execution if the above check failed because the airline already existed    
        $i = 0;
        $code = mysqli_insert_id($link);
        while ($i < $_SESSION["numberOfDestinations"] && !$error) {
            $dest = mysqli_real_escape_string($link, $_GET["destination"][$i]);
            // mysqli_insert_id - Retrieves the ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).
            $sql = "INSERT INTO destinations (airline_code, destination_city) VALUES ('" . $code . "', '" . $dest . "')";
            var_dump($sql);
            $result = mysqli_query($link, $sql);
            if (!$result) {
                var_dump($result);
                mysqli_close($link);
                $error = TRUE;
                die("QUERY 2 ERROR");
            }
            $i++;
        }
    }
    unset($_SESSION["airlineNames"]);
    unset($_SESSION["numberOfDestinations"]);
    return $error;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PA EPD06 P1</title>
    </head>
    <body>
        <h1>PA EPD06 P1: AIRLINE INFORMATION SYSTEM </h1>

        <?php
        // Display "global" options
        echo "<p>Logged in as: " . $_SESSION["user"] . "</p>";
        echo "<form method='post' action='logout.php'><input type='submit' name='logout' value='Logout'/></form><br />";
        $error = FALSE;
        if (isset($_GET["airlineCityDestinationsSubmitted"]) || $error) {
            $error = writeAirlineToDatabase("localhost", "root", "", "airlines");
            header("Location: index.php");
            exit;
        } else if (isset($_GET["airlineSubmitted"])) {
            if (!preg_match('/^[[:alnum:]]+$/', $_GET["airlineName"])) {
                $nameError = "ERROR: Airline name must be alphanumeric";
            }
            if (!is_numeric($_GET["numberOfDestinations"])) {
                $destError = "ERROR: Number of destinations must be a number";
            } else if ($_GET["numberOfDestinations"] < 1) {
                $destError = "ERROR: Number of destinations must be at least 1";
            }
        }
        if (isset($_GET["airlineSubmitted"]) && !isset($nameError) && !isset($destError)) {
            provideAirlineDestinations("localhost", "root", "", "airlines");
        } else {
            provideAirlineNameAndNumberOfDestinations(isset($nameError) ? $nameError : "", isset($destError) ? $destError : "");
        }
        ?>
    </body>
</html>
