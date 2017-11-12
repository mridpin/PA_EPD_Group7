<?php

function printErrorMessage($msg) {
    /* Prints error message in red, if it exists */
    if (isset($msg) && $msg != "") {
        echo "<p style='color:red'>" . $msg . "</p>";
    }
}

function listAirlineDestinations($airlineCode, $host, $user, $pass, $database) {
    /*
     * Returns a list of the destinations that $airlineCode currently operates, or false if database error. 
     * If there are no destinations it will return an empty list
     */
    $airlineDests = [];
    $error = false;
    $link = connectToDatabase($host, $user, $pass, $database);
    $code = mysqli_real_escape_string($link, $airlineCode);
    $sql = "SELECT destination_city FROM destinations WHERE airline_code=" . $code . "";
    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $airlineDests[] = $row[0];
        }
        mysqli_close($link);
    } else {
        var_dump($result);
        mysqli_close($link);
        $error = TRUE;
        die("LIST AIRLINE DESTINATIONS QUERY ERROR");
    }
    return ($error) ? !$error : $airlineDests;
}

function listAirlines($host, $user, $pass, $database) {
    /*
     * Returns an associative list with ["airlineCode"] => "AirlineName", or false if database error. 
     * If there are no airlines it will return an empty list 
     */
    $airlineNames = [];
    $error = false;
    $link = connectToDatabase($host, $user, $pass, $database);
    $sql = "SELECT * FROM airlines";
    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $airlineNames[$row["code"]] = $row["name"];
        }
        mysqli_close($link);
    } else {
        var_dump($result);
        mysqli_close($link);
        $error = TRUE;
        die("LIST AIRLINES QUERY ERROR");
    }
    return ($error) ? !$error : $airlineNames;
}

function findAllCurrentArrivalsForDeparture($airlineCode, $departure, $host, $user, $pass, $database) {
    /*
     * Returns a table of the arrivals and their duration that $airlineCode is currently carrying for $departure according to the flights table,
     * or false if database error. Returns an empty array if there isnt any
     */
    $flights = [];
    $error = false;
    $link = connectToDatabase($host, $user, $pass, $database);
    $code = mysqli_real_escape_string($link, $airlineCode);
    $depart = mysqli_real_escape_string($link, $departure);
    $sql = "SELECT arrival_city, duration FROM flights WHERE airline_code=" . $code . " AND departure_city='" . $depart . "'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $flights[] = $row;
        }
    } else {
        var_dump($result);
        mysqli_close($link);
        $error = TRUE;
        die("FIND ALL CURRENT ARRIVALS FOR DEPARTURE QUERY ERROR");
    }
    return ($error) ? !$error : $flights;
}

function connectToDatabase($host, $user, $pass, $database) {
    /* Connects to parameter database and returns the connection */
    $link = mysqli_connect($host, $user, $pass);
    if (!$link) {
        die("CONNECTION ERROR");
    }
    $sel_db = mysqli_select_db($link, $database);
    if (!$sel_db) {
        mysqli_close($link);
        die("SELECT ERROR");
    }
    return $link;
}

function isLoggedIn($user) {
    return isset($_SESSION[$user]) && $_SESSION[$user] != "";
}
?>

