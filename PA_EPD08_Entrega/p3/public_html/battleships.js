

var size = 5; //Only square boards allowed because we are not savages
var boardContainer = document.getElementById("boardSection");
var board = initializeBoard([size, size]);

drawBoard(board, boardContainer, size);
createButton("water.png", "waterButton");
createButton("battleship.png", "battleshipButton");

function drawBoard(board, boardContainer, size) {
    var table = document.createElement("table");
    for (var y = 0; y < size; y++) {
        var row = document.createElement("tr");
        for (var x = 0; x < size; x++) {
            var cell = document.createElement("td");
            var frame = document.createElement("figure");
            var img = document.createElement("img");
            img.setAttribute("src", "water.png");
            img.setAttribute("width", "50");
            frame.appendChild(img);
            var figcap = document.createElement("figcaption");
            var coords = document.createTextNode("[" + y + "," + x + "]");
            figcap.appendChild(coords);
            frame.appendChild(figcap);
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

function createButton (imgPath, id) {
    var button = document.createElement("button");
    var img = document.createElement("img");
    img.setAttribute("src", imgPath);
    img.setAttribute("width", "50");
    button.appendChild(img);
    button.setAttribute("id", id);
    
    //button.addEventListener("click");
    
    var buttonSection = document.getElementById("buttonSection");
    buttonSection.appendChild(button);
}