<?php

function printErrorMessage($msg) {
    /* Prints error message in red, if it exists */
    if (isset($msg) && $msg != "") {
        echo "<p style='color:red'>" . $msg . "</p>";
    }
}

function listAirlineDestinations($airlineCode, $fileName) {
    /*
     * Returns a list of the destinations that $airlineCode currently operates, or false if file error. 
     * If there are no destinations it will return an empty list
     */
    $airlineDests = [];
    $fileError = false;
    $fdests = fopen($fileName, 'r');
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
    $fairlines = fopen($fileName, 'r');
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

function findAllCurrentArrivalsForDeparture($airlineCode, $departure, $fileName) {
    /*
     * Returns a table of the flights and their duration that $airlineCode is currently carrying for $departure according to the flights file,
     * or false if file error. Returns an empty array if there isnt any
     */
    $flights = [];
    $fileError = false;
    $fflights = fopen($fileName, "r");
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
                    $currentTime = trim($line[3]);
                    $flights[] = array($currentArrival, $currentTime);
                }
            }
        }
        flock($fflights, LOCK_UN);
    } else {
        $fileError = true;
    }
    return ($fileError) ? !$fileError : $flights;
}

function checkForLogin ($user) {
    return isset($_SESSION[$user]) && $_SESSION[$user]!="";   
}
?>

