@extends('layout.gamelayout')
@section('aboveContent')
<h3 class="text-center my-2">Xếp cờ</h3>
@endsection
@section('belowContent')
<p class="w-100 text-center mt-4">
  <a id="new-board" class="w-25 btn btn-dark btn-lg"><i class="fad fa-save"></i> Lưu bàn cờ</a>
  <a id="undo" class="w-25 btn btn-light btn-lg"><i class="fad fa-redo-alt"></i> Xếp lại</a>
</p>
@if ($board != '')
<p class="w-100 text-center mt-2">
  <i class="fad fa-external-link-alt"></i> Mời bạn bè chơi bằng cách gửi liên kết.
</p>
<div id="copy-url" class="input-group mb-2 w-50 mx-auto" data-toggle="tooltip" data-placement="bottom" data-original-title="Ấn để sao chép">
  <div class="input-group-prepend">
    <span class="input-group-text" id="url-addon"><i class="fal fa-copy"></i></span>
  </div>
  <input type="text" class="form-control" id="url" value="{{ url('/') }}/xep-co/{{ $board }}">
</div>
<script>
$('#copy-url').on('click', function() {
  copyToClipboard('#url');
  selectText('#url')
});
</script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js" integrity="sha512-OqcrADJLG261FZjar4Z6c4CfLqd861A3yPNMb+vRQ2JwzFT49WT4lozrh3bcKxHxtDTgNiqgYbEUStzvZQRfgQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js" integrity="sha256-u/J1Urdrk3nCYFefpoeTMgI5viU1ujCDu2fXXoSJjhg=" crossorigin="anonymous"></script>
<script>
@if ($board != '')
let history = ['{{ $board }}'];
@else
let history = ['8/8/8/8/8/8/8/8'];
@endif
function onSnapEnd () {
  if (board.fen() != history[history.length - 1]){
    history.push(board.fen());
  }
  console.log(history);
  nuocCo.play();
}
function undo () {
  if (history.length > 1) {
    history.pop();
    board.position(history[history.length - 1]);
  }
  console.log(history);
}
const board = Chessboard('chess-board', {
  draggable: true,
  dropOffBoard: 'trash',
  sparePieces: true,
  @if ($board != '')
  position: '{{ $board }}',
  @endif
  showNotation: true,
  onSnapEnd: onSnapEnd
});
$('#new-board').on('click', function(){
  window.location.href = "{{ URL::to('/xep-co/') }}/" + board.fen();
});
$('#undo').on('click', undo);
$("#capture").on('click', function() {
  html2canvas($(".board-b72b1"), {
    windowWidth: $(".board-b72b1").width(),
    windowHeight: $(".board-b72b1").height(),
    onrendered: function(canvas) {
      var context = canvas.getContext('2d');

      // Draw the Watermark
      context.font = '42px monospace';
      context.globalCompositeOperation = 'lighter';
      context.fillStyle = '#424242';
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.fillText('COVUA.TOP', canvas.width / 2, canvas.height / 2);

      canvas.toBlob(function(blob) {
        saveAs(blob, "board-{{ date('Y-m-d g-i a') }}.png"); 
      });
    }
  });
});
</script>
@endsection
