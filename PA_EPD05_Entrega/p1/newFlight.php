<?php

function findAllPossibleArrivalsForDeparture($airlineCode, $departure) {
    /*
     * Returns the minus operation between all the possible flights for a departure from an airline and the ones that it is already carrying
     * (it can be an empty list), or false if file error.
     */
    $allPosibleFlights = listAirlineDestinations($airlineCode);
    $allCurrentFlights = findAllCurrentArrivalsForDeparture($airlineCode, $departure);
    //Remove the current departure as possible arrival ((adding it now to remove it with array_diff)
    $allCurrentFlights[] = $departure;
    if ($allCurrentFlights === FALSE || $allPosibleFlights === FALSE) {
        return false;
    } else {
        return array_diff($allPosibleFlights, $allCurrentFlights);
    }
}

function findAllCurrentArrivalsForDeparture($airlineCode, $departure) {
    /*
     * Returns a table of the flights $airlineCode is currently carrying for $departure according to the flights file,
     * or false if file error. Returns an empty array if there isnt any
     */
    $flights = [];
    $fileError = false;
    $fflights = fopen("files/flights.txt", "r");
    if ($fflights) {
        flock($fflights, LOCK_SH);
        while (!feof($fflights)) {
            $line = fgetcsv($fflights, 200);
            // Check if we are at the last line which only has empty space
            if (isset($line[1])) {
                $currentAirlineCode = trim($line[0]);
                $currentDeparture = trim($line[1]);
                $currentArrival = trim($line[2]);
                // Check if the read line is a flight from $airlineCode and $departure and add it if it is
                if ($currentAirlineCode == $airlineCode && $currentDeparture == $departure) {
                    $flights[] = $currentArrival;
                }
            }
        }
        flock($fflights, LOCK_UN);
    } else {
        $fileError = true;
    }
    return ($fileError) ? !$fileError : $flights;
}

function addFlight($airlineCode, $departure, $arrival, $time) {
    /*
     * Adds an entry to the flights file following the format specified in P1. 
     * Returns false if file error, true otherwise
     */
    $fileError = FALSE;
    $fflights = fopen("files/flights.txt", "a");
    if ($fflights) {
        $data = [];
        $data[] = filter_input(INPUT_GET, $airlineCode, FILTER_SANITIZE_STRING);
        $data[] = filter_input(INPUT_GET, $departure, FILTER_SANITIZE_STRING);
        $data[] = filter_input(INPUT_GET, $arrival, FILTER_SANITIZE_STRING);
        $data[] = filter_input(INPUT_GET, $time, FILTER_SANITIZE_STRING);
        $tuple = implode(",", $data);
        flock($fflights, LOCK_EX);
        fwrite($fflights, $tuple . PHP_EOL);
        flock($fflights, LOCK_UN);
    } else {
        $fileError = TRUE;
    }
    return !$fileError;
}

function listAirlineDestinations($airlineCode) {
    /*
     * Returns a list of the destinations that $airlineCode currently operates, or false if file error. 
     * If there are no destinations it will return an empty list
     */
    $airlineDests = [];
    $fileError = false;
    $fdests = fopen('files/destinations.txt', 'r');
    if ($fdests) {
        flock($fdests, LOCK_SH);
        while (!feof($fdests)) {
            // Needs trim to remove file reading issues with invisible characters. 
            // Apparently ($line==trim($line) = FALSE when reading from files
            $line = trim(fgets($fdests, 100));
            $explodedLine = explode(";", $line);
            if (isset($explodedLine[1])) {
                if ($explodedLine[0] == $airlineCode) {
                    $airlineDests[] = trim($explodedLine[1]);
                }
            }
        }
        flock($fdests, LOCK_UN);
        fclose($fdests);
    } else {
        $fileError = true;
    }
    return ($fileError) ? !$fileError : $airlineDests;
}

function listAirlines($fileName) {
    /*
     * Returns an associative list with ["airlineCode"] => "AirlineName", or false if file error. 
     * If there are no airlines it will return an empty list 
     */
    $airlineNames = [];
    $fileError = false;
    $fairlines = fopen('files/airlines.txt', 'r');
    if ($fairlines) {
        flock($fairlines, LOCK_SH);
        while (!feof($fairlines)) {
            $line = fgets($fairlines, 100);
            $explodedLine = explode(";", $line);
            if (isset($explodedLine[1])) {
                // Needs trim to remove file reading issues with invisible characters. 
                // Apparently ($explodedLine[1]==trim($explodedLine[1]) = FALSE
                $airlineNames[trim($explodedLine[0])] = trim($explodedLine[1]);
            }
        }
        flock($fairlines, LOCK_UN);
        fclose($fairlines);
    } else {
        $fileError = true;
    }
    return ($fileError) ? $fileError : $airlineNames;
}

function correctTimeFormat($timeString) {
    $res = preg_match("/^\d{1}:\d{2}$/", $timeString);
    if ($res===TRUE) {
        $time= explode(":", $timeString);
        $res = $res && $time[1]<=60;
    }
    return $res;
}


function printErrorMessage($msg) {
    /* Prints error message in red, if it exists */
    if (isset($msg) && $msg != "") {
        echo "<p style='color:red'>" . $msg . "</p>";
    }
}
?>

<html>
    <head>
        <title>PA EPD05 P1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1>
                PA EPD05 P1: AIRLINE INFORMATION SYSTEM                    
            </h1>            
        </header>
        <article>
            <?php
            if (isset($_GET["flightSubmitted"])) {
                // THIRD STEP: WRITE DATA TO FLIGHTS FILE AND GO TO HOME PAGE
                if (addFlight("airlineCode", "departure", "arrival", "duration")) {
                    header("Location: index.php");
                } else {
                    printErrorMessage("Flight file error");
                    echo "<a href='index.php'>Go to homepage</a>";
                }
            } else if (isset($_GET["departure"])) {
                // SECOND FORM: SELECT AVAILABLE ARRIVAL DESTINATION & FLIGHT DURATION
                /* STEP 1: Find which airline and departure we are working with from the select input */
                echo "Destination of departure selected (airline_City): " . $_GET["departure"];
                $tuple = explode("_", $_GET["departure"]);
                $airlineCode = $tuple[0];
                $departure = $tuple[1];
                /* STEP 2: Find all possible arrivals for that departure, by performing (airline destinations) minus (arrivals from that destination) */
                $possibleArrivals = findAllPossibleArrivalsForDeparture($airlineCode, $departure);
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
                        $airlineDestinations = listAirlineDestinations($airlineCode);
                        echo "<li>$airlineName:<br />";
                        foreach ($airlineDestinations as $dest) {
                            /* STEP 3: Send the airline code and the departure selected as the value of the radio button*/
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