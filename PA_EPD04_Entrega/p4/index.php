

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
        /*Check for errors in the input, 3 possible errors:
         *  1. size isnt set
         *  2. size is an empty string
         *  3. size isnt a number
         * But first, it is necessary to check if the submit button has been pressed, so that if it hasnt, it doesnt show an error msg.
         */
        if (isset ($_GET['isSubmitted'])) {
            if (isset($_GET['matrixSize']) || $_GET['matrixSize']=="" || !is_numeric($_GET['matrixSize'])) {
                $errors[] = 'Input error in matrix size field';
            }
        }
        if (!isset($errors)) {
            echo "Matriz size: " . $_GET['matrixSize']; 
        }
        if (!isset($_GET['isSubmitted']) || isset($errors)) {
            echo "<h1> . PA EPD04 P4: OPERATIONS WITH MATRICES: . </h1>";
            if (isset($errors)) {
                
            }
        }
        
    </body>
</html>
        