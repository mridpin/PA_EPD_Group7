

solutionDiv = document.getElementById("solution");
gameDiv = document.getElementById("game");
errorsDiv = document.getElementById("errors");
input = document.getElementById("input");
MAX_ERRORS = 5;
currentErrors = 0;

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

// Letter effect
$(document).ready(function () {
    $("td").click(function () {
        $(this).find("p").toggle();
    });
});