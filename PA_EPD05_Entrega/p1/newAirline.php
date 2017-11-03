<!DOCTYPE html>
<?php
/* Functions:
 *  provideAirlineNameAndNumberOfDestinations($nameError, $destError): Checks if the supplied values have errors. Then prints the form
 *  provideAirlineDestinations(): Reads the available cities from a file, then presents a form to select as many destinations
 *      as specified in the method above from the cities in the file
 *  writeAirlineToDataFiles(): creates the output data files from the data collected in the two previous methods so that the rest of the site can use them
 */

function provideAirlineNameAndNumberOfDestinations($nameError, $destError) {

    printErrorMessage($nameError);
    printErrorMessage($destError);

    echo "<form method='get' action='.'>";
    echo "Airline name: <input type='text' name='airlineName' /> <br />";
    echo "Number of destinations: <input type='text' name='numberOfDestinations' /> <br />";
    echo "<input type='submit' name='airlineSubmitted' />";
    echo "</form>";
}

function provideAirlineDestinations() {
    /* Step 1: read possible destinations from file */
    $f = fopen('files/cities.txt', 'r');
    if ($f) {
        flock($f, LOCK_SH);
        $availableCitiesList = fgetcsv($f, 999, ',');
        flock($f, LOCK_UN);
    }
    fclose($f);

    /* Step 2: print a list of selectables with the destinations in the list */
    echo "<form method='get' action '.' id='destForm'>";
    echo "Airline: " . $_GET["airlineName"] . ": <br /> Please provide a city for each destination with the dropdown menus: <br />";
    for ($i = 0; $i < $_GET["numberOfDestinations"]; $i++) {
        $name = "destination[" . $i . "]";
        echo "Destination $i: <select name=\"$name\">";
        foreach ($availableCitiesList as $city) {
            echo "<option value=\"$city\">$city</option>";
        }
        echo "</select> <br />";
    }
    echo "<input type='submit' name='airlineCityDestinationsSubmitted' />";
    echo "<input type='hidden' name='airlineName' value=\"" . $_GET["airlineName"] . "\" /> <br />";
    echo "<input type='hidden' name='numberOfDestinations' value=\"" . $_GET["numberOfDestinations"] . "\"/> <br />";
    echo "</form>";
    /* TODO: Check that cities arent repeated */
}

function writeAirlineToDataFiles() {
    $fileError = false;
    /* Step 1: file with airlines and codes */
    $fairlines = fopen('files/airlines.txt', 'a+');
    $airlineNames = [];
    $newAirlineCode = "";
    if ($fairlines) {
        flock($fairlines, LOCK_EX);
        /* First, read the whole file and create a list of airlines */
        while (!feof($fairlines)) {
            $line = fgets($fairlines, 100);
            $explodedLine = explode(";", $line);
            if (isset($explodedLine[1])) {
                $airlineNames[] = trim($explodedLine[1]);
            }
            print_r($airlineNames);
        }

        /* Now write the airline code and name separated with ; */
        $sanitizedName = filter_input(INPUT_GET, "airlineName", FILTER_SANITIZE_STRING);
        $sanitizedName = trim($sanitizedName);

        if (in_array($sanitizedName, $airlineNames) === True) {
            printErrorMessage("Airline is already in the system!");
        } else {
            $newAirlineCode = str_pad(count($airlineNames), 6, '0', STR_PAD_LEFT);
            fwrite($fairlines, $newAirlineCode . ";" . $sanitizedName . PHP_EOL);
        }
        flock($fairlines, LOCK_UN);
        fclose($fairlines);
    } else {
        $fileError = true;
    }

    /* Step 2: File with codes and destinations */
    if ($newAirlineCode !== "") { // This prevents execution if the above check failed because the airline already existed        
        $fdestinations = fopen('files/destinations.txt', 'a');
        if ($fdestinations) {
            flock($fdestinations, LOCK_EX);
            for ($i = 0; $i < $_GET["numberOfDestinations"]; $i++) {
                $newLine = $newAirlineCode . ";" . $_GET["destination"][$i];
                fwrite($fdestinations, $newLine . PHP_EOL);
            }
            flock($fdestinations, LOCK_UN);
            fclose($fdestinations);
        } else {
            $fileError = true;
        }
        return $fileError;
    }
}

function printErrorMessage($msg) {
    if (isset($msg) && $msg != "") {
        echo "<p style='color:red'>" . $msg . "</p>";
    }
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $fileError = FALSE;
        if (isset($_GET["airlineCityDestinationsSubmitted"]) || $fileError) {
            $fileError = writeAirlineToDataFiles();
            //header("Location: index.php");
            exit;
        } else if (isset($_GET["airlineSubmitted"])) {
            if (!preg_match('/^[[:alnum:]]+$/', $_GET["airlineName"])) {
                $nameError = "ERROR: Ariline name must be alphanumeric";
            }
            if (!is_numeric($_GET["numberOfDestinations"])) {
                $destError = "ERROR: Number of destinations must be a number";
            } else if ($_GET["numberOfDestinations"] < 1) {
                $destError = "ERROR: Number of destinations must be at least 1";
            }
        }
        if (isset($_GET["airlineSubmitted"]) && !isset($nameError) && !isset($destError)) {
            provideAirlineDestinations();
        } else {
            provideAirlineNameAndNumberOfDestinations(isset($nameError) ? $nameError : "", isset($destError) ? $destError : "");
        }
        ?>
    </body>
</html>
