<?php
/* Content structure:

 */

function provideOperationData() {
    /* Form control:
     * is there any data? if no, present form
     * if yes, check if the value is valid
     * if it is, proceed to next step
     * if it isnt, print error msg and present form again
     *  */
    if (isset($_GET["matrixSubmitted"])) {
        // Check for errors in matrix input. This will save a error message for each incorrect cell, so it can be printed later
        $scalarError = isNumericValidInput($_GET["scalarValue"], "scalarValue");
        for ($i = 0; $i < $_GET["matrixSize"]; $i++) {
            for ($j = 0; $j < $_GET["matrixSize"]; $j++) {
                $name = "matrix[" . $i . "][" . $j . "]";
                $matrixErrors[$i][$j] = isNumericValidInput($_GET["matrix"][$i][$j], $name);
            }
        }
        // If no errors, proceed
        if (isMatrixEmpty($matrixErrors) && !isset($scalarError)) {
            $matrix = $_GET["matrix"];
            $n = $_GET["scalarValue"];
            $resMatrix = matrixOperation1($matrix, $n);
            $resVector = matrixOperation2($matrix, $n);
            printResults($matrix, $n, $resMatrix, $resVector);
        }
    }

    if ((!isset($_GET["matrixSubmitted"])) || !isMatrixEmpty($matrixErrors) || isset($scalarError)) {
        /* Print error if it exists, continue otherwise */
        if (isset($matrixErrors)) {
            foreach ($matrixErrors as $vecErrors) {
                foreach ($vecErrors as $err) {
                    printInputError($err);
                }
            }
        }
        if (isset($scalarError)) {
            printInputError($scalarError);
        }
        processMatrixForm();
    }
}

function processMatrixForm() {
    /*
     * How to keep the values in the input fields when the user hits the submit button.
     * Source: https://www.w3schools.com/php/php_form_complete.asp
     */
    echo "<form method=\"get\" class=\"matrixData\">";
    /* If it exists, an input error has occurred */
    if (isset($_GET["scalarValue"])) {
        echo "Enter scalar value: <input type=\"text\" name=\"scalarValue\" value=\"" . $_GET["scalarValue"] . "\"" . ((is_numeric($_GET["scalarValue"])) ? $_GET["scalarValue"] : "style=\"background-color:red;\"") . ">";
    } else {
        echo "Enter scalar value: <input type=\"text\" name=\"scalarValue\">";
    }
    echo "<table>";
    for ($i = 0; $i < $_GET["matrixSize"]; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $_GET["matrixSize"]; $j++) {
            echo "<td>";
            /*
             * To access this variable name, use $_GET["matrix"][$i][$j], and NOT $_GET["matrix[$i][$j]"]. 
             * PHP automatically creates the "matrix" key entrance in $_GET[] as a 2d array with key "matrix" and two dimensions thanks to the [][]brackets
             * Check https://stackoverflow.com/questions/10911084/php-set-dynamic-array-index for more info
             */
            $name = "matrix[" . $i . "][" . $j . "]";
            echo $name . ":";
            if (isset($_GET["scalarValue"])) {
                echo "$name: <input type=\"text\" name=\"$name\" value=\"" . $_GET["matrix"][$i][$j] . "\"" . ((is_numeric($_GET["matrix"][$i][$j])) ? $_GET["matrix"][$i][$j] : "style=\"background-color:red;\"") . ">";
            } else {
                echo "<input type=\"text\" name=\"$name\">";
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    /*
     * We need to store the matrix size and send it again to the same page as a hidden input so it doesn't
     * get reset after loading the page again in case of input errors. This is an alternative to storing the value
     * in a file or a session cookie: 
     * https://stackoverflow.com/questions/16365555/how-to-keep-variable-constant-even-after-page-refresh-in-php
     */
    if (isset($_GET["matrixSize"])) {
        $matrixSize = $_GET["matrixSize"];
        echo "<input type=\"hidden\" name= \"matrixSize\" value=\"$matrixSize\" />";
    }
    echo '<input type="submit" name="matrixSubmitted" />';
    echo '</form>';
}

function isNumericValidInput($inputValue, $inputName) {
    /* Check for errors in the input, 3 possible errors:
     *  1. input isnt set
     *  2. input is an empty string
     *  3. input isnt a number         * 
     */
    if (!isset($inputValue) || !is_numeric($inputValue)) {
        $error = 'Input error in ' . $inputName . ' field:' . '"' . $inputValue . '" is not a valid value';
    }
    if (isset($error)) {
        return $error;
    }
}

function isMatrixEmpty($matrix) {
    /* Returns true if $matrix is null, or ALL of its values are !isset() */
    $res = TRUE;
    if (is_array($matrix)) {
        foreach ($matrix as $vec) {
            foreach ($vec as $value) {
                $res = $res && !isset($value);
            }
        }
    }
    return $res;
}

function printInputError($error) {
    if (isset($error)) {
        echo "<p style='color:red'>" . $error . "</p>";
    }
}

function matrixOperation1($matrix, $n) {
    $size = isValidMatrix($matrix, $n);
    if ($size == false) {
        return false;
    } else {
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($j < $i) {
                    $matrix[$i][$j] = $n;
                }
            }
        }
        return $matrix;
    }
}

function isValidMatrix($matrix, $n) {
    /* Returns false if sum(elements)<n or if matrix is non square. 
     * Returns size of matrix otherwise */
    $size = count($matrix);
    $totalValue = 0;
    foreach ($matrix as $row) {
        if ($size != count($row)) {
            /* Discards non square matrices */
            return false;
        }
        foreach ($row as $data) {
            $totalValue += $data;
        }
    }
    if ($n > $totalValue) {
        return false;
    } else {
        return $size;
    }
}

function matrixOperation2($matrix, $n) {
    $size = count($matrix);
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($j == $i) {
                $res[$i] = $matrix[$i][$j] * $n;
            }
        }
    }
    return $res;
}

function printResults($matrix, $n, $resMatrix, $resVector) {
    echo "<h2>ORIGINAL MATRIX:</h2>";
    printMatrix($matrix);
    echo "<h2>ORIGINAL NUMBER:</h2>";
    echo $n;
    echo "<h2>FIRST OP MATRIX RESULT:</h2>";
    printMatrix($resMatrix);
    echo "<h2>SECOND OP VECTOR RESULT:</h2>";
    printVector($resVector);
}

function printMatrix($matrix) {
    echo "<table>";
    foreach ($matrix as $row) {
        echo "<tr>\n";
        foreach ($row as $data) {
            echo "<td>" . sprintf("%02s", $data) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function printVector($vec) {
    echo "<table>";
    echo "<tr>\n";
    foreach ($vec as $data) {
        echo "<td>" . sprintf("%02s", $data) . "</td>";
    }
    echo "</tr>";
    echo "</table>";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>
            PA EPD04 P4: OPERATIONS WITH MATRICES:
        </h1>
        <?php
        provideOperationData();
        ?>
    </body>
</html>