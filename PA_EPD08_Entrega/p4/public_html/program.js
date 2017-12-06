

var solutionDiv = document.getElementById("solution");
var gameDiv = document.getElementById("game");
var errorsDiv = document.getElementById("errors");
var input = document.getElementById("input");
var MAX_ERRORS = 5;

startGame(solutionDiv, gameDiv, errorsDiv);

function startGame(solutionDiv, gameDiv, errorsDiv) {
    var word = prompt("Insert a word to guess");
    // TODO: Regex the word
    createSolutionDiv(solutionDiv, word);
    createGameDiv(gameDiv, word);
    createErrorCounter(errorsDiv, word);
    var currentErrors = 0;
    var input = document.getElementById("input");
    input.addEventListener("keypress", function () {
        return processKey(event, word, currentErrors);
    });
    
}

function createSolutionDiv(solutionDiv, word) {
    var p = document.createElement("p");
    var text = document.createTextNode("Hover mouse here to see solution: ");
    var hiddenWord = document.createElement("span");
    hiddenWord.appendChild(document.createTextNode(word));
    hideAndRevealOnHover(hiddenWord);
    p.style.border = "2px solid black";
    p.appendChild(text);
    p.appendChild(hiddenWord);
    solutionDiv.appendChild(p);

}

function hideAndRevealOnHover(hiddenWord) {
    // Make it invisible
    hiddenWord.style.color = "white";
    hiddenWord.onmouseover = function () {
        makeVisible(this);
    };
    hiddenWord.onmouseout = function () {
        makeInvisible(this);
    };
}

function makeVisible(hiddenWord) {
    hiddenWord.style.color = "black";
}
function makeInvisible(hiddenWord) {
    hiddenWord.style.color = "white";
}

function createGameDiv(gameDiv, word) {
    var strlen = word.length;
    var results = document.getElementById("results");
    var underscores = document.getElementById("underscores");
    for (var i = 0; i < strlen; i++) {
        var cellUp = document.createElement("td");
        var cellLow = document.createElement("td");
        cellLow.appendChild(document.createTextNode("_"));
        results.appendChild(cellUp);
        underscores.appendChild(cellLow);
    }
}

function createErrorCounter(errorsDiv, word) {
    var p = document.createElement("p");
    var text = document.createTextNode("Errors: ");
    var errorCount = document.createElement("span");
    errorCount.appendChild(document.createTextNode(""));
    p.style.border = "2px solid black";
    p.appendChild(text);
    p.appendChild(errorCount);
    errorsDiv.appendChild(p);
}

function processKey(event, word, currentErrors) {    
    var letter = event.keyCode;
    
    
    
}