/* Functions content structure:
 *      - provideOperationData: First of the two main functions, does form control, 
 *          presents the form, and proceeds to the calculations if everything is correct.
 *      - processMatrixForm: Second main function. Presents the matrix form to the user, 
 *          collects the data and highlights incorrect values in red.
 *      - isNumericValidInput: Checks if the parameter is valid and returns an
 *          error message if it isn't. The error message is used to check if the form needs to be shown again
 *      - isMatrixEmpty: returns true if a matrix is 100% empty a matrix is value if for all its values: isset(value)==FALSE
 *      - printInputErrors: Prints the error message from isNumericValidInput, if it exists.
 *      - matrixoperation1: Performs the first matrix operation from EPD03_P5
 *      - isValidMatrix: Performs the condition check from EPD03_P5
 *      - matrixoperation2: Performs the second matrix operation from EPD03_P5
 *      - printResults: Prints the results as HTML
 *      - printMatrix: Prints a matrix using HTML tables
 *      - printVector: Prints a vector as an HTML table with one row
 */ 