@extends('en.layout.gamelayout')
@section('aboveContent')
<h3 class="text-center my-2">Shared board</h3>
<div class="dropup mx-auto text-center">
  <button class="btn btn-lg btn-dark dropdown-toggle" type="button" id="levelDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fal fa-trophy"></i> Choose board level
  </button>
  <div class="dropdown-menu" aria-labelledby="levelDropdown">
    <a class="add-fen dropdown-item" href="{{ url('/newbie-board') }}">Newbie</a>
    <a class="add-fen dropdown-item" href="{{ url('/easy-board') }}">Easy</a>
    <a class="add-fen dropdown-item" href="{{ url('/normal-board') }}">Normal</a>
    <a class="add-fen dropdown-item" href="{{ url('/hard-board') }}">Hard</a>
    <a class="add-fen dropdown-item" href="{{ url('/hardest-board') }}">Hardest</a>
  </div>
</div>
@endsection
@section('belowContent')
<p class="w-100 text-center mt-4">
  <a id="switch" class="w-25 btn btn-dark btn-lg"><i class="fad fa-chess-board"></i> Switch side</a>
  <a id="reset" class="w-25 btn btn-light btn-lg"><i class="fad fa-redo-alt"></i> Restart</a>
</p>
<p class="w-100 text-center mt-2">
  <i class="fad fa-external-link-alt"></i> Inviting friend to play by sending the link.
</p>
<div id="copy-url" class="input-group mb-2 w-50 mx-auto" data-toggle="tooltip" data-placement="bottom" data-original-title="Click to copy">
  <div class="input-group-prepend">
    <span class="input-group-text" id="url-addon"><i class="fal fa-copy"></i></span>
  </div>
  <input type="text" class="form-control" id="url" value="{{ url()->current() }}">
</div>
<script>
$('#copy-url').on('click', function() {
  copyToClipboard('#url');
  selectText('#url')
});
</script>
<script>
let board = null;
let $board = $('#chess-board');
let game = new Chess();

var promoting = false;
var piece_theme = $('#piecesUrl').val() + '/img/chesspieces/wikipedia/{piece}.png';
var promotion_dialog = $('#promotion-dialog');
var promote_to = '';
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
  updateStatus();
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

let config = {
  draggable: true,
  position: '{{ $fen }}',
  onDragStart: onDragStart,
  onDrop: onDrop,
  onMouseoutSquare: onMouseoutSquare,
  onMouseoverSquare: onMouseoverSquare,
  onSnapEnd: onSnapEnd,
  showNotation: true
  //pieceTheme: '/static/img/xiangqipieces/traditional/{piece}.svg'
};
board = Chessboard('chess-board', config)
game.load('{{ $fen }}');

updateStatus();
$(document).ready(function() {
  $('#FEN').val(game.fen());
  if (game.turn() === 'b') {
    board.flip();
  }
});
$('#reset').on('click', function() {
  board.position('{{ $fen }}');
  game.load('{{ $fen }}');
  // board.position('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR');
  // game.load('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
  updateStatus();
  $('#game-over').removeClass('d-inline-block').addClass('d-none');
});
$('#switch').on('click', board.flip);
$('.add-fen').each(function(){
  $(this).on('click', function(){
    $(this).attr('href', $(this).attr('href') + '/' + game.fen());
  });
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