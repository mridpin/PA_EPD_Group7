<?php
function provideMatrixSize() {
    /* Form control:
     * is there any data? if no, present form
     * if yes, check if the value is valid
     * if it is, proceed to next step
     * if it isnt, print error msg and present form again
     *  */
    if (isset($_GET["sizeSubmitted"])) {
        /* check for errors: if there are no errors, print the input */
        $sizeError = is_numeric($_GET["matrixSize"]);
        if (!isset($sizeError)) {
            echo "<h2>MATRIX SIZE:</h2>" . $_GET["matrixSize"];
        }
    }

    /* present the form the the user if it hasnt been submitted or there are errors (or both) */
    if (!isset($_GET["sizeSubmitted"]) || isset($sizeError)) {
        /* Print error if it exists, continue otherwise */
        if (isset($sizeError)) {
            printInputError($sizeError);
        }
        
        ?> <!--close php part to print the form with html -->

        <form method="get" class="sizeForm" action="dataInput.php"> <!-- sends it to the same page -->
            Please provide matrix size: <input type="number" name="matrixSize" required="required"/>
            <input type="submit" name="sizeSubmitted" />
        </form>
        <?php
    }
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
        ?>
    </body>
</html>
