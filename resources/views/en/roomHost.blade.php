@extends('en.layout.gamelayout')
@section('aboveContent')
<p id="room-code" class="w-100 text-center mt-2">
  <span class="alert alert-info d-inline-block" role="alert" data-toggle="tooltip" data-placement="bottom" data-original-title="Remember this room code"><i class="fad fa-trophy-alt"></i> Room code: {{ $roomCode }}</span>
</p>
<div id="change-pass" class="input-group mb-4 w-50 mx-auto">
  <label class="m-auto" for="inputPassword">New password</label>
  <input type="password" id="inputPassword" class="form-control mx-2" required />
  <button type="submit" id="changePassword" class="btn btn-primary" onclick="validateForm();">Change</button>
  <div id="status" class="w-100"></div>
</div>
<p class="w-100 text-center mt-2">
  <i class="fad fa-external-link-alt"></i> Inviting friend to play by sending the link.
</p>
<div id="copy-url" class="input-group mb-2 w-50 mx-auto" data-toggle="tooltip" data-placement="bottom" data-original-title="Click to copy">
  <div class="input-group-prepend">
    <span class="input-group-text" id="url-addon"><i class="fal fa-copy"></i></span>
  </div>
  <input type="text" class="form-control" id="url" value="{{ url('/') }}/room/{{ $roomCode }}/invited">
</div>
@endsection
@section('belowContent')
<p class="w-100 text-center mt-4">
  <a id="white-link" class="w-25 btn btn-light btn-lg" href="{{ URL::to('/') }}/room/{{ $roomCode }}/white"><i class="fad fa-chess-clock-alt"></i> WHITE side</a>
  <a id="black-link" class="w-25 btn btn-dark btn-lg" href="{{ URL::to('/') }}/room/{{ $roomCode }}/black"><i class="fad fa-chess-clock"></i> BLACK side</a>
</p>
<script>
function validateForm() {
  document.getElementById('status').innerHTML = "Processing...";
  formData = {
    'room-code': '{{ $roomCode }}',
    'pass': $('#inputPassword').val()
  };
  $.ajax({
    url: "{{ url('/api') }}/changePass",
    type: "POST",
    data : formData,
    dataType: 'json',
    success: function(data, textStatus, jqXHR)
    {
      $('#status').text(data.message);
      console.log(data);
      if (data.code) //If mail was sent successfully, reset the form.
      $('#inputPassword').val("");
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      $('#status').text(jqXHR);
    }
  });
}
$(document).ready(function() {
  bootbox.prompt({
    title: "Please enter the password for this Room:",
    required: true,
    centerVertical: true,
    callback: function(password){
      if (password && password != "") {
        $.ajax({
          type: "GET",
          url: '{{ url('/api') }}/getPass/' + '{{ $roomCode }}',
          dataType: 'text'
        }).done(function(data) {
          if (data != password) {
            bootbox.alert({
              message: "Wrong password! You will be redirected to the Home page",
              size: 'small',
              centerVertical: true,
              callback: function () {
                window.location.href = '{{ url('/en') }}';
              }
            });
          }
        });
      } else {
        bootbox.alert({
          message: "You clicked Cancel! You will be redirected to the Home page",
          size: 'small',
          centerVertical: true,
          callback: function () {
            window.location.href = '{{ url('/en') }}';
          }
        });
      }
    }
  });
});
var board = null
var game = new Chess()
var currentFEN = game.fen()

var promoting = false;
var piece_theme = $('#piecesUrl').val() + '/img/chesspieces/wikipedia/{piece}.png';
var promotion_dialog = $('#promotion-dialog');
var promote_to = '';
var whiteSquareGrey = '#a9a9a9'
var blackSquareGrey = '#696969'

function updateFenCode(roomCode) {
  board.position(game.fen(), true);
  game.load(game.fen());
  $.ajax({
    type: "POST",
    url: '{{ url('/api') }}/updateFEN',
    data: {
      'room-code': roomCode,
      'FEN': game.fen()
    },
    dataType: 'text'
  });
}

function manipulateRoom(roomCode) {
  $.ajax({
    type: "GET",
    url: '{{ url('/api') }}/readFEN/' + roomCode,
    dataType: 'text'
  }).done(function(newFEN) {
    if (newFEN != currentFEN) {
      currentFEN = game.fen();
      if (newFEN == game.fen()) {
        // my move
      } else {
        // opponent's move
        board.position(newFEN, true);
        game.load(newFEN);
        nuocCo.play();
        if (game.game_over()) {
          hetTran.play();
          $('#game-over').removeClass('d-none').addClass('d-inline-block');
        }
      }
    }
    updateStatus()
  });
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
  
  if ((board.orientation() == 'white' && game.turn() === 'b') || (board.orientation() == 'black' && game.turn() === 'w')) {
    return false;
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
  nuocCo.play();
  updateFenCode('{{ $roomCode }}');
  if (game.game_over()) {
    hetTran.play();
    $('#game-over').removeClass('d-none').addClass('d-inline-block');
  }
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
    $('#header-status').html(': '+status+' - Game over');
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
  showNotation: false,
  orientation: "white"
  //pieceTheme: '/static/img/xiangqipieces/traditional/{piece}.svg'

};
board = Chessboard('chess-board', config)

updateStatus()
window.onload = function(){
  if (board.orientation() == 'white' && game.turn() === 'b') {
    location.href = $('#black-link').attr('href');
  }
};
let evtSource = new EventSource("{{ url('/api') }}/getFEN/{{ $roomCode }}");

evtSource.onmessage = function (e) {
  let newFEN = e.data;
    console.log(newFEN);
    if (newFEN != currentFEN) {
    currentFEN = game.fen();
    $.ajax({
      type: "POST",
      url: '{{ url('/api') }}/updateFEN',
      data: {
        'room-code': '{{ $roomCode }}',
        'FEN': newFEN
      },
      dataType: 'text'
    });
    if (newFEN == game.fen()) {
      // my move
      board.position(newFEN, true);
      game.load(newFEN);
    } else {
      // opponent's move
      board.position(newFEN, true);
      game.load(newFEN);
      nuocCo.play();
      if (game.game_over()) {
        hetTran.play();
        $('#game-over').removeClass('d-none').addClass('d-inline-block');
      }
    }
  }
  updateStatus();
};
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
    updateFenCode('{{ $roomCode }}');
  });
}
});
</script>
@endsection