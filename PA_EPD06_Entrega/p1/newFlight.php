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

function findAllPossibleArrivalsForDeparture($airlineCode, $departure, $host, $user, $pass, $database) {
    /*
     * Returns the minus operation between all the possible flights for a departure from an airline and the ones that it is already carrying
     * (it can be an empty list), or false if database error.
     */
    $allPosibleFlights = listAirlineDestinations($airlineCode, $host, $user, $pass, $database);
    $allCurrentFlights = array_column(findAllCurrentArrivalsForDeparture($airlineCode, $departure, $host, $user, $pass, $database), 0);
    //Remove the current departure as possible arrival (adding it now to remove it with array_diff)
    $allCurrentFlights[] = $departure;
    if ($allCurrentFlights === FALSE || $allPosibleFlights === FALSE) {
        return false;
    } else {
        return array_diff($allPosibleFlights, $allCurrentFlights);
    }
}

function addFlight($data, $host, $user, $pass, $database) {
    /*
     * Adds an entry to the flights table following the format specified in P1. 
     * Returns false if database error, true otherwise
     */
    $error = FALSE;
    $link = connectToDatabase($host, $user, $pass, $database);
    // The data are already sanitized before calling this function
    $duration = explode(":", $data[3]);
    $minutes = $duration[0] * 60 + $duration[1];
    $sql = "INSERT INTO flights (airline_code, departure_city, arrival_city, duration) VALUES ('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $minutes . "')";
    $result = mysqli_query($link, $sql);
    if ($result) {
        mysqli_close($link);
    } else {
        var_dump($result);
        mysqli_close($link);
        $error = TRUE;
        die("ADD FLIGHT QUERY ERROR");
    }
    return !$error;
}

function correctTimeFormat($timeString) {
    $res = preg_match("/[[:digit:]]{2}:[[:digit:]]{2}/", $timeString);
    if ($res === TRUE) {
        $time = explode(":", $timeString);
        $res = $res && $time[1] <= 60;
    }
    return $res;
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
        </header>
        <article>
            <?php
            // Display "global" options
            echo "<p>Logged in as: " . $_SESSION["user"] . "</p>";
            echo "<form method='post' action='logout.php'><input type='submit' name='logout' value='Logout'/></form><br />";

            if (isset($_GET["flightSubmitted"]) && (isset($_GET["duration"]) && correctTimeFormat($_GET["duration"]))) {
                // THIRD STEP (NO FORM SHOWN): WRITE DATA TO FLIGHTS TABLE AND GO TO HOME PAGE
                $data = [];
                $data[] = filter_var($_SESSION["airlineCode"], FILTER_SANITIZE_STRING);
                $data[] = filter_var($_SESSION["departure"], FILTER_SANITIZE_STRING);
                $data[] = filter_input(INPUT_GET, "arrival", FILTER_SANITIZE_STRING);
                $data[] = filter_input(INPUT_GET, "duration", FILTER_SANITIZE_STRING);
                unset($_SESSION["airlineCode"]);
                unset($_SESSION["departure"]);
                if (addFlight($data, "localhost", "root", "", "airlines")) {
                    header("Location: index.php");
                } else {
                    printErrorMessage("Flight table error");
                    echo "<a href='index.php'>Go to homepage</a>";
                }
            } else if (isset($_GET["departure"])) {
                // SECOND FORM: SELECT AVAILABLE ARRIVAL DESTINATION & FLIGHT DURATION
                /* STEP 1: Find which airline and departure we are working with from the previous select input */
                if (isset($_GET["duration"]) && !correctTimeFormat($_GET["duration"])) {
                    printErrorMessage("Wrong time format, please use hh:mm");
                    echo "<a href='newFlight.php'>Select another destination</a>";
                } else {
                    echo "Destination of departure selected (airline_City): " . $_GET["departure"];
                    $tuple = explode("_", $_GET["departure"]);
                    $airlineCode = $tuple[0];
                    $departure = $tuple[1];
                    /* STEP 2: Find all possible arrivals for that departure, by performing (airline destinations) minus (arrivals from that destination) */
                    $possibleArrivals = findAllPossibleArrivalsForDeparture($airlineCode, $departure, "localhost", "root", "", "airlines");
                    if (count($possibleArrivals) == 0) {
                        printErrorMessage("All destinations for $airlineCode departing from $departure already have flights");
                        echo "<a href='newFlight.php'>Select another destination</a>";
                    } else {
                        echo "<form method='get' action='newFlight.php''>";
                        /* STEP 3: Provide those destinations as a select form */
                        echo "<select name='arrival'>";
                        foreach ($possibleArrivals as $arrival) {
                            echo "<option value=\"$arrival\">$arrival</option>";
                        }
                        echo "</select><br />";
                        /* STEP 4: Capture the duration and send the airline and departure as session variable to write in table */
                        echo "Flight duration [Format: hh:mm, 00<=hh<=24, 00<=mm<=60]: <input type='text' name='duration' /><br />";
                        $_SESSION["airlineCode"] = $airlineCode;
                        $_SESSION["departure"] = $departure;                        
                        echo "<input type='submit' name='flightSubmitted' />";
                        echo "</form>";
                    }
                }
            } else {
                // FIRST FORM: SELECT DEPARTURE DESTINATION
                // We assume there are no possible input errors with this step, since there is no text input and only selecting radio buttons
                /* STEP 1: Create associative list of code=>name from airlines table */
                $airlines = listAirlines("localhost", "root", "", "airlines");
                if ($airlines !== FALSE) {
                    /* STEP 2: For each airline, read a list of its destinations from the table and display radio buttons to select one */
                    echo "<form method='get' action='newFlight.php''>";
                    echo "<ol>";
                    foreach ($airlines as $airlineCode => $airlineName) {
                        $airlineDestinations = listAirlineDestinations($airlineCode, "localhost", "root", "", "airlines");
                        echo "<li>$airlineName:<br />";
                        foreach ($airlineDestinations as $dest) {
                            /* STEP 3: Send the airline code and the departure selected as the value of the radio button */
                            // $airlineCode_$dest will let us know later which airline and destination was selected.
                            echo "<input type='radio' name='departure' value=\"" . $airlineCode . "_" . $dest . "\" />$dest<br />";
                        }
                        echo "</li>";
                    }
                    echo "</ol>";
                    echo "<input type='submit' name='departureSubmitted' />";
                    echo "</form>";
                } else {
                    printErrorMessage("Airline table error");
                    echo "<a href='index.php'>Go to homepage</a>";
                }
            }
            ?> 
        </article>
    </body>
</html>