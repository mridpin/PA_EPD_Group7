<?php
/* Content structure:
 *      Generic functions:
 *          isNumericValidInput
 *          printInputErrors
 *      Ask for matrix size:
 *          provideMatrixSize

 */

function isNumericValidInput($inputName) {
    /* Check for errors in the input, 3 possible errors:
     *  1. input isnt set
     *  2. input is an empty string
     *  3. input isnt a number         * 
     */
    if (!isset($_GET[$inputName]) || $_GET[$inputName] == "" || !is_numeric($_GET[$inputName])) {
        $errors = 'Input error in ' . $inputName . ' field';
    }
    return $errors;
}

function printInputErrors($errors) {
    if (!empty($errors)) {
        foreach ($errors as $e) {
            echo "<p style='color:red'>" . $e . "</p>";
        }
    }
}

function provideMatrixSize() {
    $errors = [];
    /* Form control */
    if (isset($_GET['isSubmitted'])) {
        /* if there are no errors, print the input */
        $errors[] = isNumericValidInput("matrixSize");
        if (empty($errors)) {
            echo "Matriz size: " . $_GET['matrixSize'];
        }
    }

    /* present the form the the user if it hasnt been submitted or there are errors (or both) */
    if (!isset($_GET['isSubmitted']) || !empty($errors)) {
        printInputErrors($errors);
        ?> <!--close php part to print the form with html -->

        <form method="get" class="sizeForm"> <!-- sends it to the same page -->
            Please provide matrix size: <input type="text" name="matrixSize"/>
            <input type="submit" name="isSubmitted" />
        </form>
        <?php
    }
}

function provideOperationData() {
    //$errors = [][]; //errors is a 2D array of strings
    //$errors = isNumericValidInput("scalarValue");
    //$matrix = [][];
    for ($i = 0; $i < $_GET["matrixSize"]; $i++) {
        for ($j = 0; $j < $_GET["matrixSize"]; $j++) {
            // Coords in matrix have "matrix(x, y)" as keys
            $errors[$i][$j] = isNumericValidInput($_GET["matrix(" . $i . ", " . $j . ")"]);
        }
    }
    /* present the form the the user if it hasnt been submitted or there are errors (or both) */
    if (!isset($_GET['isSubmitted']) || !empty($errors)) {
        foreach ($errors as $err) {
            printInputErrors($err);
        }
        printMatrixForm();
    }
}

function printMatrixForm() {
    echo '<form method="get" class="matrixData">';
    echo "<table>";
    for ($i = 0; $i < $_GET["matrixSize"]; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $_GET["matrixSize"]; $j++) {
            echo "<td>";
            echo '<input type="text" name="matrix(' . $i . ', ' . $j . ')" />';
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo '<input type="submit" name="isSubmitted" />';
    echo '</form>';
}
?>

<html>
    <head>
        <meta charset = "UTF-8">
        <title>PA EPD04 P4</title>
    </head>
    <body> 
        <h1>
            PA EPD04 P4: OPERATIONS WITH MATRICES:
        </h1>
<?php
provideMatrixSize();
provideOperationData();
?>
    </body>
</html>
