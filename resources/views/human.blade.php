@extends('layout.gamelayout')
@section('aboveContent')
<h3 class="text-center my-2">Đang chơi với nhau</h3>
@endsection
@section('belowContent')
<p class="w-100 text-center mt-4">
  <a class="w-25 btn btn-dark btn-lg" href="{{ url('/') }}"><i class="fad fa-desktop"></i> Chơi với máy</a>
  <a id="reset" class="w-25 btn btn-light btn-lg"><i class="fad fa-redo-alt"></i> Chơi lại</a>
</p>
<script>
let board = null;
let $board = $('#chess-board');
let game = new Chess();

var promoting = false;
var piece_theme = $('#piecesUrl').val() + '/img/chesspieces/alpha/{piece}.png';
var promotion_dialog = $('#promotion-dialog');
var promote_to = '';
var squareToHighlight = null
var squareClass = 'square-55d63'
var whiteSquareGrey = '#a9a9a9'
var blackSquareGrey = '#696969'

function removeHighlights (color) {
  $board.find('.' + squareClass).removeClass('highlight-' + color)
}

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

function onDragStart (source, piece, position, orientation) {
  // do not pick up pieces if the game is over
  if (game.game_over()) return false

  // only pick up pieces for the side to move
  if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
      (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
    return false
  }
}

function onDrop (source, target) {
  removeGreySquares();

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

  if (move.color === 'w') {
    removeHighlights('white');
    $board.find('.square-' + source).addClass('highlight-white');
    $board.find('.square-' + target).addClass('highlight-white');
    squareToHighlight = target;
    colorToHighlight = 'white';
  } else {
    removeHighlights('black');
    $board.find('.square-' + source).addClass('highlight-black');
    $board.find('.square-' + target).addClass('highlight-black');
    squareToHighlight = target;
    colorToHighlight = 'black';
  }
  updateStatus()
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

function onMouseoverSquare (square, piece) {
  // get list of possible moves for this square
  let moves = game.moves({
    square: square,
    verbose: true
  });

  // exit if there are no moves available for this square
  if (moves.length === 0) return;

  // highlight the square they moused over
  greySquare(square);

  // highlight the possible squares for this piece
  for (let i = 0; i < moves.length; i++) {
    greySquare(moves[i].to);
  }
}

function onMouseoutSquare (square, piece) {
  removeGreySquares();
}

function onSnapEnd () {
  board.position(game.fen());
  $('#FEN').val(game.fen());
  nuocCo.play();
  if (game.game_over()) {
    hetTran.play();
    $('#game-over').removeClass('d-none').addClass('d-inline-block');
  }
  if (promoting) return;
  promoting = false;
}

function onMoveEnd () {
  $board.find('.square-' + squareToHighlight).addClass('highlight-' + colorToHighlight);
}

function updateBoard(board) {
  board.position(game.fen(), false);
  promoting = false;
}

function updateStatus () {
  var status = ''

  var moveColor = 'Trắng'
  if (game.turn() === 'b') {
    moveColor = 'Đen'
  }

  // checkmate?
  if (game.in_checkmate()) {
    status = moveColor + ' bị chiếu bí'
  }

  // draw?
  else if (game.in_draw()) {
    status = 'Hòa'
  }

  // game still on
  else {
    status = 'Tới lượt ' + moveColor + ' đi'

    // check?
    if (game.in_check()) {
      status += ', ' + moveColor + ' đang bị chiếu'
    }
  }

  $('#game-status').html(status);
  $('#header-status').html(': '+status);
  if (game.game_over()) {
    $('#header-status').html(': '+status+' - Hết trận');
  }
}

let config = {
  draggable: true,
  position: 'start',
  onDragStart: onDragStart,
  onDrop: onDrop,
  onMouseoutSquare: onMouseoutSquare,
  onMouseoverSquare: onMouseoverSquare,
  onSnapEnd: onSnapEnd,
  onMoveEnd: onMoveEnd,
  showNotation: false
  //pieceTheme: '/static/img/xiangqipieces/traditional/{piece}.svg'
};
board = Chessboard('chess-board', config)

updateStatus();
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
