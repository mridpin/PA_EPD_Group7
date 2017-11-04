<?php

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

function findAllCurrentArrivalsForDeparture($airlineCode, $departure) {
    /*
     * Returns a table of the flights and their duration that $airlineCode is currently carrying for $departure according to the flights file,
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
            if (isset($_GET["airline"])) {
                echo "Showing information for airline: " . $_GET["airline"];
                echo "<table style='border:solid;>";
                echo "<tr style='font-weight:bold;'>";
                echo "<th>Destination</th>";
                echo "<th>Number of flights</th>";
                echo "<th>Average flight time (h)</th>";
                echo "</tr>";
                $airlineCode = filter_input(INPUT_GET, "airline", FILTER_SANITIZE_STRING);
                /* STEP 1: Create a count($destinations)*3 matrix with all the data for the table */
                $tableData = [];
                $destinations = listAirlineDestinations($airlineCode);
                foreach ($destinations as $dest) {
                    $avgTime = 0;
                    $flights = findAllCurrentArrivalsForDeparture($airlineCode, trim($dest));
                    $totalMinutes = 0;
                    foreach ($flights as $flight) {
                        $time = explode(":", $flight[1]);
                        $totalMinutes = $time[0] * 60 + $time[0];
                    }
                    $numOfFlights = count($flights);
                    $tableData[] = array($dest, $numOfFlights, ($numOfFlights==0) ? 0 : ($totalMinutes/$numOfFlights/60));
                }
                /*Sort the data table by number of flights (column 1) */
                usort($tableData, function ($a, $b) {
                    // Sorts the matrix using the function provided
                    // More information in https://stackoverflow.com/questions/2699086/sort-multi-dimensional-array-by-value
                    return $b[2]-$a[2];                    
                });
                foreach ($tableData as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // FIRST FORM: SELECT AIRLINE
                // We assume there are no possible errors with this step, since there is no text input and only selecting radio buttons
                echo "<form method='get' action='listFlights.php'>";
                $airlines = listAirlines("files/airlines.txt");
                echo "Please select an airline to view info:<br />";
                foreach ($airlines as $code => $name) {
                    echo "<input type='radio' name='airline' value=\"$code\" />" . $name . "<br />";
                }
                echo "<input type='submit' name='airlineSubmitted' />";
                echo "</form>";
            }
            ?>
        </article>
    </body>
</html>

