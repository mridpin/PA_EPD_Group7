<?php
include 'functions.php';
require_once 'functions.php';

function findAllPossibleArrivalsForDeparture($airlineCode, $departure, $destFile, $flightFile) {
    /*
     * Returns the minus operation between all the possible flights for a departure from an airline and the ones that it is already carrying
     * (it can be an empty list), or false if file error.
     */
    $allPosibleFlights = listAirlineDestinations($airlineCode, $destFile);
    $allCurrentFlights = array_column(findAllCurrentArrivalsForDeparture($airlineCode, $departure, $flightFile), 0);
    //Remove the current departure as possible arrival (adding it now to remove it with array_diff)
    $allCurrentFlights[] = $departure;
    if ($allCurrentFlights === FALSE || $allPosibleFlights === FALSE) {
        return false;
    } else {
        return array_diff($allPosibleFlights, $allCurrentFlights);
    }
}

function addFlight($data, $fileName) {
    /*
     * Adds an entry to the flights file following the format specified in P1. 
     * Returns false if file error, true otherwise
     */
    $fileError = FALSE;
    $fflights = fopen($fileName, "a");
    if ($fflights) {
        $tuple = implode(",", $data);
        flock($fflights, LOCK_EX);
        fwrite($fflights, $tuple . PHP_EOL);
        flock($fflights, LOCK_UN);
    } else {
        $fileError = TRUE;
    }
    return !$fileError;
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
        <title>PA EPD06 EJ1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1>
                PA EPD06 EJ1: AIRLINE INFORMATION SYSTEM                   
            </h1>            
        </header>
        <article>
            <?php
            if (isset($_GET["flightSubmitted"]) && (isset($_GET["duration"]) && correctTimeFormat($_GET["duration"]))) {
                // THIRD STEP: WRITE DATA TO FLIGHTS FILE AND GO TO HOME PAGE
                $data = [];
                $data[] = filter_input(INPUT_GET, "airlineCode", FILTER_SANITIZE_STRING);
                $data[] = filter_input(INPUT_GET, "departure", FILTER_SANITIZE_STRING);
                $data[] = filter_input(INPUT_GET, "arrival", FILTER_SANITIZE_STRING);
                $data[] = filter_input(INPUT_GET, "duration", FILTER_SANITIZE_STRING);
                if (addFlight($data, "files/flights.txt")) {
                    header("Location: index.php");
                } else {
                    printErrorMessage("Flight file error");
                    echo "<a href='index.php'>Go to homepage</a>";
                }
            } else if (isset($_GET["departure"])) {
                // SECOND FORM: SELECT AVAILABLE ARRIVAL DESTINATION & FLIGHT DURATION
                /* STEP 1: Find which airline and departure we are working with from the select input */
                if (isset($_GET["duration"]) && !correctTimeFormat($_GET["duration"])) {
                    printErrorMessage("Wrong time format, please use hh:mm");
                    echo "<a href='newFlight.php'>Select another destination</a>";
                } else {
                    echo "Destination of departure selected (airline_City): " . $_GET["departure"];
                    $tuple = explode("_", $_GET["departure"]);
                    $airlineCode = $tuple[0];
                    $departure = $tuple[1];
                    /* STEP 2: Find all possible arrivals for that departure, by performing (airline destinations) minus (arrivals from that destination) */
                    $possibleArrivals = findAllPossibleArrivalsForDeparture($airlineCode, $departure, "files/destinations.txt", "files/flights.txt");
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
                        /* STEP 4: Capture the duration and send the airline and departure as hidden input to write in file */
                        echo "Flight duration [Format: hh:mm, 00<=hh<=24, 00<=mm<=60]: <input type='text' name='duration' /><br />";
                        echo "<input type='submit' name='flightSubmitted' />";
                        echo "<input type='hidden' name='airlineCode' value='$airlineCode' />";
                        echo "<input type='hidden' name='departure' value='$departure' />";
                        echo "</form>";
                    }
                }
            } else {
                // FIRST FORM: SELECT DEPARTURE DESTINATION
                // We assume there are no possible errors with this step, since there is no text input and only selecting radio buttons
                /* STEP 1: Create associative list of code=>name from airlines file */
                $airlines = listAirlines("files/airlines.txt");
                if ($airlines !== FALSE) {
                    /* STEP 2: For each airline, read a list of its destinations from file and display radio buttons to select one */
                    echo "<form method='get' action='newFlight.php''>";
                    echo "<ol>";
                    foreach ($airlines as $airlineCode => $airlineName) {
                        $airlineDestinations = listAirlineDestinations($airlineCode, "files/destinations.txt");
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
                    printErrorMessage("Airline file error");
                    echo "<a href='index.php'>Go to homepage</a>";
                }
            }
            ?> 
        </article>
    </body>
</html>