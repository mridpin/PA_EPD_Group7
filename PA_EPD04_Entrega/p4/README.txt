/* Functions content structure:
 *      - provideMatrixSize: First of the three main functions: does form control and 
 *          presents the form for the matrix size if the value doesn't exist or if it has errors
 *      - provideOperationData: Second of the three main functions: prints the errors in the data input
 *          if they exist, and presents the form
 *      - processMatrixForm: Third main function. Presents the matrix form to the user, 
 *          collects the data and highlights incorrect values in red.
 *      - performOperations: performs the operations with matrix and scalar
 *      - isNumericValidInput: Checks if the parameter is valid and returns an
 *          error message if it isn't. The error message is used to check if the form needs to be shown again and to 
 *          pinpoint exactly what the error is.
 *      - isMatrixEmpty: returns true if a matrix is 100% empty. a matrix is empty if for all its values: isset(value)==FALSE
 *      - printInputErrors: Prints the error message from isNumericValidInput, if it exists.
 *      - matrixoperation1: Performs the first matrix operation from EPD03_P5
 *      - isValidMatrix: Performs the condition check from EPD03_P5
 *      - matrixoperation2: Performs the second matrix operation from EPD03_P5
 *      - printResults: Prints the results as HTML
 *      - printMatrix: Prints a matrix using HTML tables
 *      - printVector: Prints a vector as an HTML table with one row
 * 
 *  Program structure:
 *      The program is divided in three if else blocks. Starting from the bottom, each if-else requieres the previous to be correct
 *      That is, to prompt for data input, we require a valid matrix size, and to perform the operations, we require a valid matrix and scalar
 *      The parameter checks are done from most selective to least selective, in order to repeat the conditions that are needed for the next operation
 */ 