$(document).ready(function () {
  var squares = ["", "", "", "", "", "", "", "", ""];
  var player = "X";
  var messageElement = $(".message");
  var restartButton = $("#restart-button");
  var counter = 0;
  restartButton.hide();

  function checkWin() {
    // Check rows
    for (var i = 0; i <= 6; i += 3) {
      if (squares[i] === player && squares[i + 1] === player && squares[i + 2] === player) {
        return true;
      }
    }

    // Check columns
    for (var i = 0; i <= 2; i++) {
      if (squares[i] === player && squares[i + 3] === player && squares[i + 6] === player) {
        return true;
      }
    }
    
    // Check diagonals
    if (squares[0] === player && squares[4] === player && squares[8] === player) {
      return true;
    }
    if (squares[2] === player && squares[4] === player && squares[6] === player) {
      return true;
    }
    return false;
  }

  function updateBoard() {
    $(".square").each(function (index) {
      $(this).text(squares[index]);
      if (squares[index] === "X") {
        $(this).addClass("playerX");
        $(this).removeClass("playerO");
      } else if (squares[index] === "O") {
        $(this).addClass("playerO");
        $(this).removeClass("playerX");
      } else {
        $(this).removeClass("playerX");
        $(this).removeClass("playerO");
      }
    });
  }

  function resetBoard() {
    squares = ["", "", "", "", "", "", "", "", ""];
    player = "X";
    messageElement.text("It's " + player + "'s turn!");
    updateBoard();
    counter = 0;
  }

  $(".square").click(function () {
    if (checkWin()) {
      return;
    }
    
    var index = $(this).attr("id");
    if (squares[index] === "") {
      squares[index] = player;
      updateBoard();
      
      if (checkWin()) {
        messageElement.text("Player " + player + " wins!");
        restartButton.show();
      } else {
        player = player === "X" ? "O" : "X";
        messageElement.text("It's " + player + "'s turn!");
        counter++;
        
        if (counter === 9) {
          messageElement.text("It's a tie!");
          restartButton.show();
        }
      }
    }
  });

  restartButton.click(function () {
    resetBoard();
    restartButton.hide();
  });

});
