

var solutionDiv = document.getElementById("solution");
var gameDiv = document.getElementById("game");
var errorsDiv = document.getElementById("errors");
var input = document.getElementById("input");
var MAX_ERRORS = 5;
var currentErrors = 0;

startGame(solutionDiv, gameDiv, errorsDiv);

function startGame(solutionDiv, gameDiv, errorsDiv) {
    var word = prompt("Insert a word to guess");
    createSolutionDiv(solutionDiv, word);
    createGameDiv(gameDiv, word);
    createErrorCounter(errorsDiv, word);
    var input = document.getElementById("input");
    input.onkeyup = function () {
        return processKey(this, word);
    };

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
    errorCount.id = "errorCount";
    errorCount.appendChild(document.createTextNode("0"));
    p.style.border = "2px solid black";
    p.appendChild(text);
    p.appendChild(errorCount);
    errorsDiv.appendChild(p);
}

function processKey(input, word) {
    // Captures the value of the input and validates it as good or error. Deletes it afterwards
    var letter = input.value;
    if (letter === "") {
        alert("key not valid");
    } else {
        var occurrences = getAllIndices(word, letter);
        if (occurrences.length === 0) {
            errorUp();
        } else {
            drawLetter(letter, occurrences);
        }
        // Delete the value for next time value
        input.value = "";
        if (checkIfWin(word)) {
            alert("YOU WON");
        }
    }

}

function getAllIndices(word, letter) {
    // Returns an array with all occurrences of letter in word: https://stackoverflow.com/questions/20798477/how-to-find-index-of-all-occurrences-of-element-in-array
    var indices = []
    var i = -1;
    while ((i = word.indexOf(letter, i + 1)) !== -1) {
        indices.push(i);
    }
    return indices;
}

function drawLetter(letter, occurrences) {
    // Prints letter in the corresponding cell in the table by iterating through occurrences
    var resultRow = document.getElementById("results");
    var cells = resultRow.childNodes;
    for (var x in occurrences) {
        if (cells[occurrences[x] + 1].textContent !== letter) {
            cells[occurrences[x] + 1].appendChild(document.createTextNode(letter)); //index+1 because first child is text
        }
    }
}

function errorUp() {
    currentErrors = currentErrors + 1;
    var errCounter = document.getElementById("errorCount");
    errCounter.textContent = currentErrors.toString();
    if (currentErrors === MAX_ERRORS) {
        alert("YOU LOST");
    }
}

function checkIfWin(word) {
    var cells = document.getElementById("results").childNodes;
    var res = true;
    var i = 0;
    while (i<=word.length && res) {
        if (cells[i].textContent === "") {
            res = false;
        }
        i++;
    }
    return res;
}