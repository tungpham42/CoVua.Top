@extends('en.layout.gamelayout')
@section('aboveContent')
<h3 class="text-center my-2">Playing with AI</h3>
<h4 class="text-center my-2">Level: {{ $levelTxt }}</h4>
<div class="dropup mx-auto text-center">
  <button class="btn btn-lg btn-dark dropdown-toggle" type="button" id="levelDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fal fa-trophy"></i> Choose level
  </button>
  <div class="dropdown-menu" aria-labelledby="levelDropdown">
    <a class="dropdown-item" href="{{ url('/newbie') }}">Newbie</a>
    <a class="dropdown-item" href="{{ url('/easy') }}">Easy</a>
    <a class="dropdown-item" href="{{ url('/normal') }}">Normal</a>
    <a class="dropdown-item" href="{{ url('/hard') }}">Hard</a>
    <a class="dropdown-item" href="{{ url('/hardest') }}">Hardest</a>
  </div>
</div>
@endsection
@section('belowContent')
<p class="w-100 text-center mt-4">
  <a class="w-25 btn btn-dark btn-lg" href="{{ url('/play-with-friend') }}"><i class="fad fa-user"></i> Play with friend</a>
  <a id="reset" class="w-25 btn btn-light btn-lg"><i class="fad fa-redo-alt"></i> Restart</a>
</p>
<script>
var board = null
var game = new Chess()

var promoting = false;
var piece_theme = $('#piecesUrl').val() + '/img/chesspieces/alpha/{piece}.png';
var promotion_dialog = $('#promotion-dialog');
var promote_to = '';
var whiteSquareGrey = '#a9a9a9'
var blackSquareGrey = '#696969'

function removeGreySquares () {
  $('#chess-board .square-55d63').css('background', '')
}

function greySquare (square) {
  var $square = $('#chess-board .square-' + square)

  var background = whiteSquareGrey
  if ($square.hasClass('black-3c85d')) {
    background = blackSquareGrey
  }

  $square.css('background', background)
}

function minimaxRoot(depth, game, isMaximisingPlayer) {
  var newGameMoves = game.ugly_moves();
  var bestMove = -9999;
  var bestMoveFound;

  for(var i = 0; i < newGameMoves.length; i++) {
    var newGameMove = newGameMoves[i]
    game.ugly_move(newGameMove);
    var value = minimax(depth - 1, game, -10000, 10000, !isMaximisingPlayer);
    game.undo();
    if(value >= bestMove) {
      bestMove = value;
      bestMoveFound = newGameMove;
    }
  }
  return bestMoveFound;
}

function minimax(depth, game, alpha, beta, isMaximisingPlayer) {
  positionCount++;
  if (depth === 0) {
    return -evaluateBoard(game.board());
  }

  var newGameMoves = game.ugly_moves();

  if (isMaximisingPlayer) {
    var bestMove = -9999;
    for (var i = 0; i < newGameMoves.length; i++) {
      game.ugly_move(newGameMoves[i]);
      bestMove = Math.max(bestMove, minimax(depth - 1, game, alpha, beta, !isMaximisingPlayer));
      game.undo();
      alpha = Math.max(alpha, bestMove);
      if (beta <= alpha) {
        return bestMove;
      }
    }
    return bestMove;
  } else {
    var bestMove = 9999;
    for (var i = 0; i < newGameMoves.length; i++) {
      game.ugly_move(newGameMoves[i]);
      bestMove = Math.min(bestMove, minimax(depth - 1, game, alpha, beta, !isMaximisingPlayer));
      game.undo();
      beta = Math.min(beta, bestMove);
      if (beta <= alpha) {
        return bestMove;
      }
    }
    return bestMove;
  }
}

function evaluateBoard(board) {
  var totalEvaluation = 0;
  for (var i = 0; i < 8; i++) {
    for (var j = 0; j < 8; j++) {
      totalEvaluation = totalEvaluation + getPieceValue(board[i][j], i ,j);
    }
  }
  return totalEvaluation;
}

function reverseArray(array) {
  return array.slice().reverse();
}

var pawnEvalWhite = [
  [0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0],
  [5.0,  5.0,  5.0,  5.0,  5.0,  5.0,  5.0,  5.0],
  [1.0,  1.0,  2.0,  3.0,  3.0,  2.0,  1.0,  1.0],
  [0.5,  0.5,  1.0,  2.5,  2.5,  1.0,  0.5,  0.5],
  [0.0,  0.0,  0.0,  2.0,  2.0,  0.0,  0.0,  0.0],
  [0.5, -0.5, -1.0,  0.0,  0.0, -1.0, -0.5,  0.5],
  [0.5,  1.0, 1.0,  -2.0, -2.0,  1.0,  1.0,  0.5],
  [0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0]
];

var pawnEvalBlack = reverseArray(pawnEvalWhite);

var knightEval = [
  [-5.0, -4.0, -3.0, -3.0, -3.0, -3.0, -4.0, -5.0],
  [-4.0, -2.0,  0.0,  0.0,  0.0,  0.0, -2.0, -4.0],
  [-3.0,  0.0,  1.0,  1.5,  1.5,  1.0,  0.0, -3.0],
  [-3.0,  0.5,  1.5,  2.0,  2.0,  1.5,  0.5, -3.0],
  [-3.0,  0.0,  1.5,  2.0,  2.0,  1.5,  0.0, -3.0],
  [-3.0,  0.5,  1.0,  1.5,  1.5,  1.0,  0.5, -3.0],
  [-4.0, -2.0,  0.0,  0.5,  0.5,  0.0, -2.0, -4.0],
  [-5.0, -4.0, -3.0, -3.0, -3.0, -3.0, -4.0, -5.0]
];

var bishopEvalWhite = [
  [ -2.0, -1.0, -1.0, -1.0, -1.0, -1.0, -1.0, -2.0],
  [ -1.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -1.0],
  [ -1.0,  0.0,  0.5,  1.0,  1.0,  0.5,  0.0, -1.0],
  [ -1.0,  0.5,  0.5,  1.0,  1.0,  0.5,  0.5, -1.0],
  [ -1.0,  0.0,  1.0,  1.0,  1.0,  1.0,  0.0, -1.0],
  [ -1.0,  1.0,  1.0,  1.0,  1.0,  1.0,  1.0, -1.0],
  [ -1.0,  0.5,  0.0,  0.0,  0.0,  0.0,  0.5, -1.0],
  [ -2.0, -1.0, -1.0, -1.0, -1.0, -1.0, -1.0, -2.0]
];

var bishopEvalBlack = reverseArray(bishopEvalWhite);

var rookEvalWhite = [
  [  0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0],
  [  0.5,  1.0,  1.0,  1.0,  1.0,  1.0,  1.0,  0.5],
  [ -0.5,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -0.5],
  [ -0.5,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -0.5],
  [ -0.5,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -0.5],
  [ -0.5,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -0.5],
  [ -0.5,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -0.5],
  [  0.0,   0.0, 0.0,  0.5,  0.5,  0.0,  0.0,  0.0]
];

var rookEvalBlack = reverseArray(rookEvalWhite);

var evalQueen = [
  [ -2.0, -1.0, -1.0, -0.5, -0.5, -1.0, -1.0, -2.0],
  [ -1.0,  0.0,  0.0,  0.0,  0.0,  0.0,  0.0, -1.0],
  [ -1.0,  0.0,  0.5,  0.5,  0.5,  0.5,  0.0, -1.0],
  [ -0.5,  0.0,  0.5,  0.5,  0.5,  0.5,  0.0, -0.5],
  [  0.0,  0.0,  0.5,  0.5,  0.5,  0.5,  0.0, -0.5],
  [ -1.0,  0.5,  0.5,  0.5,  0.5,  0.5,  0.0, -1.0],
  [ -1.0,  0.0,  0.5,  0.0,  0.0,  0.0,  0.0, -1.0],
  [ -2.0, -1.0, -1.0, -0.5, -0.5, -1.0, -1.0, -2.0]
];

var kingEvalWhite = [
  [ -3.0, -4.0, -4.0, -5.0, -5.0, -4.0, -4.0, -3.0],
  [ -3.0, -4.0, -4.0, -5.0, -5.0, -4.0, -4.0, -3.0],
  [ -3.0, -4.0, -4.0, -5.0, -5.0, -4.0, -4.0, -3.0],
  [ -3.0, -4.0, -4.0, -5.0, -5.0, -4.0, -4.0, -3.0],
  [ -2.0, -3.0, -3.0, -4.0, -4.0, -3.0, -3.0, -2.0],
  [ -1.0, -2.0, -2.0, -2.0, -2.0, -2.0, -2.0, -1.0],
  [  2.0,  2.0,  0.0,  0.0,  0.0,  0.0,  2.0,  2.0 ],
  [  2.0,  3.0,  1.0,  0.0,  0.0,  1.0,  3.0,  2.0 ]
];

var kingEvalBlack = reverseArray(kingEvalWhite);

function getPieceValue(piece, x, y) {
  if (piece === null) {
    return 0;
  }
  var getAbsoluteValue = function (piece, isWhite, x ,y) {
    if (piece.type === 'p') {
      return 10 + ( isWhite ? pawnEvalWhite[y][x] : pawnEvalBlack[y][x] );
    } else if (piece.type === 'r') {
      return 50 + ( isWhite ? rookEvalWhite[y][x] : rookEvalBlack[y][x] );
    } else if (piece.type === 'n') {
      return 30 + knightEval[y][x];
    } else if (piece.type === 'b') {
      return 30 + ( isWhite ? bishopEvalWhite[y][x] : bishopEvalBlack[y][x] );
    } else if (piece.type === 'q') {
      return 90 + evalQueen[y][x];
    } else if (piece.type === 'k') {
      return 900 + ( isWhite ? kingEvalWhite[y][x] : kingEvalBlack[y][x] );
    }
    throw "Unknown piece type: " + piece.type;
  };

  var absoluteValue = getAbsoluteValue(piece, piece.color === 'w', x ,y);
  return piece.color === 'w' ? absoluteValue : -absoluteValue;
}

function onDragStart (source, piece, position, orientation) {
  if (game.in_checkmate() === true || game.in_draw() === true || piece.search(/^b/) !== -1) {
    return false;
  }
}

function makeBestMove() {
  var bestMove = getBestMove(game);
  game.ugly_move(bestMove);
  board.position(game.fen());
  nuocCo.play();
  updateStatus();
}

var positionCount;
function getBestMove(game) {
  updateStatus();
  positionCount = 0;
  //var depth = parseInt($('#search-depth').find(':selected').text());
  var depth = {{ $level }};
  var bestMove = minimaxRoot(depth, game, true);
  return bestMove;
}

function makeRandomMove () {
  var possibleMoves = game.moves()

  // game over
  if (possibleMoves.length === 0) return

  var randomIdx = Math.floor(Math.random() * possibleMoves.length)
  game.move(possibleMoves[randomIdx])
  board.position(game.fen())
  updateStatus()
}

function onDrop (source, target) {
  move_cfg = {
    from: source,
    to: target,
    promotion: 'q'
  };
  var move = game.move(move_cfg);
  // illegal move
  if (move === null) {
    return 'snapback';
  } else {
    game.undo(); //move is ok, now we can go ahead and check for promotion
  }
 
  // is it a promotion?
  var source_rank = source.substring(2,1);
  var target_rank = target.substring(2,1);
  var piece = game.get(source).type;

  if (piece === 'p' &&
      ((source_rank === '7' && target_rank === '8') || (source_rank === '2' && target_rank === '1'))) {
        promoting = true;

    // get piece images
    $('.promotion-piece-q').attr('src', getImgSrc('q'));
    $('.promotion-piece-r').attr('src', getImgSrc('r'));
    $('.promotion-piece-n').attr('src', getImgSrc('n'));
    $('.promotion-piece-b').attr('src', getImgSrc('b'));

    //show the select piece to promote to dialog
    promotion_dialog.dialog({
      modal: true,
      height: 46,
      width: 184,
      resizable: true,
      draggable: false,
      close: onDialogClose,
      closeOnEscape: false,
      dialogClass: 'noTitleStuff'
    }).dialog('widget').position({
      of: $('#chess-board'),
      my: 'middle middle',
      at: 'middle middle',
    });
    //the actual move is made after the piece to promote to
    //has been selected, in the stop event of the promotion piece selectable
    return;
  }

  // no promotion, go ahead and move
  makeMove(game, move_cfg);
  updateStatus()
  // make random legal move for black
  window.setTimeout(makeBestMove, 1000)
}

function getImgSrc(piece) {
  return piece_theme.replace('{piece}', game.turn() + piece.toLocaleUpperCase());
}

var onDialogClose = function() {
  // console.log(promote_to);
  move_cfg.promotion = promote_to;
  makeMove(game, move_cfg);
}

function makeMove(game, cfg) {
  // see if the move is legal
  var move = game.move(cfg);
  // illegal move
  if (move === null) return 'snapback';
}

// update the board position after the piece snap
// for castling, en passant, pawn promotion
function onMouseoverSquare (square, piece) {
  // get list of possible moves for this square
  var moves = game.moves({
    square: square,
    verbose: true
  })

  // exit if there are no moves available for this square
  if (moves.length === 0) return

  // highlight the square they moused over
  greySquare(square)

  // highlight the possible squares for this piece
  for (var i = 0; i < moves.length; i++) {
    greySquare(moves[i].to)
  }
}

function onMouseoutSquare (square, piece) {
  removeGreySquares()
}

function onSnapEnd () {
  board.position(game.fen())
  nuocCo.play();
  updateStatus();
  if (promoting) return;
  promoting = false;
}

function updateBoard(board) {
  board.position(game.fen(), false);
  promoting = false;
}

function updateStatus () {
  var status = ''

  var moveColor = 'White'
  if (game.turn() === 'b') {
    moveColor = 'Black'
  }

  // checkmate?
  if (game.in_checkmate()) {
    status = moveColor + ' is in checkmate'
  }

  // draw?
  else if (game.in_draw()) {
    status = 'Drawn position'
  }

  // game still on
  else {
    status = moveColor + "'s turn to move"

    // check?
    if (game.in_check()) {
      status += ', ' + moveColor + ' is in check'
    }
  }

  $('#game-status').html(status);
  $('#header-status').html(': '+status);
  if (game.game_over()) {
    hetTran.play();
    $('#header-status').html(': '+status+' - Game over');
    $('#game-over').removeClass('d-none').addClass('d-inline-block');
  }
}

var config = {
  draggable: true,
  position: 'start',
  onDragStart: onDragStart,
  onDrop: onDrop,
  onMouseoutSquare: onMouseoutSquare,
  onMouseoverSquare: onMouseoverSquare,
  onSnapEnd: onSnapEnd,
  showNotation: false
}

board = Chessboard('chess-board', config)

updateStatus()
$(document).ready(function() {
  $('#FEN').val(game.fen());
});
$('#reset').on('click', function() {
  board.position('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR');
  game.load('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
  updateStatus();
  $('#game-over').removeClass('d-inline-block').addClass('d-none');
});
// init promotion piece dialog
$("#promote-to").selectable({
stop: function() {
  $( ".ui-selected", this ).each(function() {
    var selectable = $('#promote-to li');
    var index = selectable.index(this);
    if (index > -1) {
      var promote_to_html = selectable[index].innerHTML;
      var span = $('<div>' + promote_to_html + '</div>').find('span');
      promote_to = span[0].innerHTML;
    }
    promotion_dialog.dialog('close');
    $('.ui-selectee').removeClass('ui-selected');
    updateBoard(board);
    updateStatus();
  });
}
});
</script>
@endsection