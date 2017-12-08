

//GLOBAL VARIABLES  
var size = 5; //Only square boards allowed because we are not savages
var boardContainer = document.getElementById("boardSection");
/* board will hold the following values:
 *  0: water
 *  1: tile with new ship or ship part
 */
var board = initializeBoard([size, size]);
var shipCounter = document.getElementById("shipCounter");
var shipCounterText = document.createTextNode("0");
shipCounter.appendChild(shipCounterText);
var maxShips = 6;
/*Global variable for button clicked:
 *  0: nothing selected
 *  1: water selected
 *  2: ship selected
 */
var buttonClicked = 0;

/*Global variable for ship effect:
 *  0: fade
 *  1: slide
 */
var shipEffect = 0;

/*Initialize board. "Gameplay" is event driven, so there is no action or game loop*/
drawBoard(boardContainer, size);
createButton("water.png", "waterButton");
createButton("battleship.png", "battleshipButton");

function drawBoard(boardContainer, size) {
    var table = document.createElement("table");
    for (var y = 0; y < size; y++) {
        var row = document.createElement("tr");
        for (var x = 0; x < size; x++) {
            var cell = document.createElement("td");
            // Doubly nested functions are needed because of the for loop, so that each cell uses itself as parameter. 
            // If only one nested function, the parameter is always the last cell
            cell.addEventListener("click", function (pos) {
                return function () {
                    paintBoard(pos);
                    return false;
                };
            }(cell));
            //Step 1: Create the images
            var frame = document.createElement("figure");
            var img = document.createElement("img");
            img.setAttribute("src", "water.png");
            img.setAttribute("width", "50");
            frame.appendChild(img);
            //Step 2: Create the captions
            var figcap = document.createElement("figcaption");
            var coords = document.createTextNode("[" + y + "," + x + "]");
            figcap.appendChild(coords);
            frame.appendChild(figcap);
            // Step 3: build the table
            cell.appendChild(frame);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    table.setAttribute("border", "2");
    boardContainer.appendChild(table);
}

function initializeBoard(dimensions) {
    var vec = [];
    for (var i = 0; i < dimensions[0]; i++) {
        // Check if base case
        if (dimensions.length === 1) {
            vec.push(0);
        } else {
            vec.push(initializeBoard(dimensions.slice(1)));
        }
    }
    return vec;
}

function createButton(imgPath, id) {
    var button = document.createElement("button");
    var img = document.createElement("img");
    img.setAttribute("src", imgPath);
    img.setAttribute("width", "100");
    button.appendChild(img);
    button.setAttribute("id", id);

    //Add a listener to the buttons to save which one was the last pressed
    button.addEventListener("click", function () {
        elementClicked(this.id);
        return false;
    });

    var buttonSection = document.getElementById("buttonSection");
    buttonSection.appendChild(button);
}

/* This function is called when the buttons are clicked. It will set the global variable to whatever is clicked, ie
 water, ship or nothing */
function elementClicked(id) {
    switch (id) {
        case "waterButton":
            buttonClicked = 1;
            break;
        case "battleshipButton":
            buttonClicked = 2;
            break;
        default:
            break;
    }
}

/*Replaces the image in pos according to the value of the global variable. Also updates the board variable*/
function paintBoard(pos) {
    x = pos.cellIndex;
    y = pos.parentNode.rowIndex;
    figure = pos.firstChild;
    //Check what are we painting, then update the image, then update the matrix
    if (buttonClicked === 1) {
        var img = document.createElement("img");
        img.setAttribute("src", "water.png");
        img.setAttribute("width", "5");
        figure.replaceChild(img, figure.firstChild);
        $(document).ready(function () {
            // https://stackoverflow.com/questions/14820710/jquery-ui-size-effect-on-hover-then-return-to-original-size
            $(img).animate({width: 50, height: 5}, 500);
            $(img).animate({width: 50, height: 50}, 500);
        });
        board[y][x] = 0;
    } else if (buttonClicked === 2) {
        var img = document.createElement("img");
        img.setAttribute("src", "battleship.png");
        img.setAttribute("width", "50");
        img.style.display = "none";
        figure.replaceChild(img, figure.firstChild);
        board[y][x] = 1;
        switch (shipEffect) {
            case 0:
                $(document).ready(function () {
                    $(img).fadeIn(3000);
                });
                shipEffect = 1;
                break;
            case 1:
                $(document).ready(function () {
                    $(img).show("slide", {direction: "up"}, 1000);
                });
                shipEffect = 0;
                break;
            default:
                break;
        }
    }
    if (checkShipIntegrity(maxShips, shipCounter)) {
        alert("Maximum ships placed");
    }
}
function checkShipIntegrity(maxShipsAllowed, currentShipCounter) {
    /* Counts the ships and prints the information*/
    var currentShips = countShips();
    var currentShipsText = document.createTextNode(currentShips.toString());
    currentShipCounter.replaceChild(currentShipsText, currentShipCounter.firstChild);

    return currentShips >= maxShipsAllowed;
}

function countShips() {
    /*To count ships, we iterate horizontally. If we find a 1, we start "filling" a ship. If the next place is 0, 
     * the ship is reset. If the next place is a 1, we fill the ship until a 0 or a board limit is found. 
     * Then, we do the same vertically, but allowing 1 piece ships. If two ships are in T or L shape, the horizontal one will be longer  */
    var maxShipSize = parseInt(document.getElementById("shipSize").value);
    var shipCounter = []; // Array of ships
    var ship = []; //Array of ship pieces
    var newBoard = copyMatrix(board); // Copy of board to count. Counted ship pieces are a 2 in the matrix

    /* Iterate horizontally */
    for (var i = 0; i < newBoard.length; i++) {
        for (var j = 0; j < newBoard.length; j++) {
            // Horizontal iteration
            if (newBoard[i][j] === 1) {
                ship.push(1);
                newBoard[i][j] = 2;
            }
            if (newBoard[i][j] === 0 && ship.length === 1) {
                // A vertical ship or a single piece ship has been found, reset the ship counter
                ship.length = 0;
                newBoard[i][j - 1] = 1;
            }

            if ((newBoard[i][j] === 0 && ship.length > 1) || (ship.length === maxShipSize)) {
                // Create a new ship if we find water or the ship is already full
                shipCounter.push(ship);
                ship.length = 0;
            }
        }
        // Board edge reached, add the current ship if valid and reset the ship builder:
        if (ship.length > 1) {
            shipCounter.push(ship);
        } else if (ship.length === 1) {
            // This check prevents one piece horizontal ships from appearing in the top right side of board
            newBoard[i][j - 1] = 1;
        }
        ship.length = 0;
    }
    /* Iterate vertically */
    for (var i = 0; i < newBoard.length; i++) {
        for (var j = 0; j < newBoard.length; j++) {
            // Vertical iteration
            if ((newBoard[j][i] === 0 || newBoard[j][i] === 2) && ship.length >= 1) {
                // Create a new ship if we find water, another ship, or the ship is already full
                shipCounter.push(ship);
                ship.length = 0;
            } else if (newBoard[j][i] === 1) {
                ship.push(1);
                newBoard[j][i] = 2;
            }
            if (ship.length === maxShipSize) {
                shipCounter.push(ship);
                ship.length = 0;
            }
        }
        // Board edge reached, add the current ship if valid and reset the ship builder:
        if (ship.length >= 1) {
            shipCounter.push(ship);
        }
        ship.length = 0;
    }
    return shipCounter.length;
}

function copyMatrix(matrix) {
    var newMatrix = [];
    for (var i = 0; i < matrix.length; i++) {
        newMatrix[i] = matrix[i].slice();
    }
    return newMatrix;
}