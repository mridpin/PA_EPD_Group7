

var size = 5; //Only square boards allowed because we are not savages
var boardContainer = document.getElementById("boardSection");
var board = initializeBoard([size, size]);

/*Global variable for button clicked:
 *  0: nothing selected
 *  1: water selected
 *  2: ship selected
 */
var buttonClicked = 0;

drawBoard(board, boardContainer, size);
createButton("water.png", "waterButton");
createButton("battleship.png", "battleshipButton");

function drawBoard(board, boardContainer, size) {
    var table = document.createElement("table");
    for (var y = 0; y < size; y++) {
        var row = document.createElement("tr");
        for (var x = 0; x < size; x++) {
            var cell = document.createElement("td");
            // Doubly nested functions are needed so that each cell uses itself as parameter. 
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
    //alert(buttonClicked);
}

/*Replaces the image in pos according to the value of the global variable. Also updates the board variable*/
function paintBoard(pos) {
    x = pos.cellIndex;
    y = pos.parentNode.rowIndex;
    figure = pos.firstChild;
    if (buttonClicked === 1) {
        var img = document.createElement("img");
        img.setAttribute("src", "water.png");
        img.setAttribute("width", "50");
        figure.replaceChild(img, figure.firstChild);
    } else if (buttonClicked === 2) {
        var img = document.createElement("img");
        img.setAttribute("src", "battleship.png");
        img.setAttribute("width", "50");
        figure.replaceChild(img, figure.firstChild);
    }
}