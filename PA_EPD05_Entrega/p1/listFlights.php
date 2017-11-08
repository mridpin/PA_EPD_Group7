<?php
include 'functions.php';
require_once 'functions.php';

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
                $destinations = listAirlineDestinations($airlineCode, "files/destinations.txt");
                foreach ($destinations as $dest) {
                    $avgTime = 0;
                    $flights = findAllCurrentArrivalsForDeparture($airlineCode, trim($dest), "files/flights.txt");
                    $totalMinutes = 0;
                    foreach ($flights as $flight) {
                        $time = explode(":", $flight[1]);
                        $totalMinutes += $time[0] * 60 + $time[1];
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

