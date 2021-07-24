<!DOCTYPE html>
<html lang="vi">
  <head>
    @include('layout.partials.head')
  </head>
  <body class="{{ $bodyClass }}">
    @include('layout.partials.header')
    <main>
      <div class="container-fluid game px-0" itemscope itemtype="http://schema.org/Game">
        <div class="container {{ isset($board) ? 'px-3 pb-0 pt-3' : 'p-3' }}">
          <audio id="nuoc-co">
            <source src="{{ URL::to('/') }}/sound/nuocCo.mp3" type="audio/mpeg">
            <source src="{{ URL::to('/') }}/sound/nuocCo.wav" type="audio/wav">
            Your browser does not support the audio element.
          </audio>
          <audio id="het-tran">
            <source src="{{ URL::to('/') }}/sound/hetTran.mp3" type="audio/mpeg">
            <source src="{{ URL::to('/') }}/sound/hetTran.wav" type="audio/wav">
            Your browser does not support the audio element.
          </audio>
          @if ( isset($board) )
          <p class="w-100 text-center">
            <a id="capture" class="btn btn-dark btn-lg" href="javascript:void(0);"><i class="fal fa-camera-retro"></i> Chụp bàn cờ thế</a>
          </p>
          @endif
          <div id="chess-board" class="w-50 mx-auto"></div>
          <div id="promotion-dialog">
            <ol id="promote-to">
              <li class="ui-state-default"><span class="piece-name">q</span><img class="promotion-piece-q promotion-piece" /></li>
              <li class="ui-state-default"><span class="piece-name">r</span><img class="promotion-piece-r promotion-piece" /></li>
              <li class="ui-state-default"><span class="piece-name">n</span><img class="promotion-piece-n promotion-piece" /></li>
              <li class="ui-state-default"><span class="piece-name">b</span><img class="promotion-piece-b promotion-piece" /></li>
            </ol>
          </div>
          <p class="w-100 text-center my-3">
            <span class="d-inline-block rounded" id="game-status"></span>
          </p>
          <p class="w-100 text-center mt-2">
            <span class="rounded d-none" id="game-over" data-toggle="tooltip" data-placement="top" data-original-title="Ấn 'Tạo phòng mới' để chơi ván khác nhé"><i class="fad fa-flag-checkered"></i> HẾT TRẬN</span>
          </p>
          <p class="w-100 text-center my-4">
            <a id="create-room" data-room="{{ md5(time()) }}" data-url="{{ URL::to('/') }}/phong/{{ md5(time()) }}" class="btn btn-success btn-lg"><i class="fad fa-plus-circle"></i> Tạo phòng mới</a>
          </p>
          @yield('aboveContent')
          <div class="row">
            <input type="hidden" name="FEN" id="FEN" />
            <input type="hidden" name="piecesUrl" id="piecesUrl" value="{{ URL::to('/') }}" />
            @include('layout.partials.scripts')
            @yield('belowContent')
            @if ( !isset($board) )
            <p class="w-100 text-center mt-2">
              <a id="share-board" class="text-light mx-auto btn btn-success btn-lg py-2" href="{{ URL::to('/ban-co/') }}"><i class="fad fa-share"></i> Chia sẻ bàn cờ</a>
            </p>
            <script>
            $('#share-board').on('click', function(){
              $(this).attr('href', $(this).attr('href') + '/' + game.fen());
            });
            </script>
            @else
            <h3 class="mx-auto text-center my-2 d-block w-100">Ai đi trước?</h3>
            <p class="w-100 text-center mt-2">
              <a id="white-first" class="w-25 btn btn-light btn-lg" href="{{ URL::to('/ban-co/') }}"><i class="fad fa-chess-clock-alt"></i> Trắng</a>
              <a id="black-first" class="w-25 btn btn-dark btn-lg" href="{{ URL::to('/ban-co/') }}"><i class="fad fa-chess-clock"></i> Đen</a>
            </p>
            <script>
            $('#white-first').on('click', function(){
              $(this).attr('href', $(this).attr('href') + '/' + board.fen() + ' w - - 0 1');
            });
            $('#black-first').on('click', function(){
              $(this).attr('href', $(this).attr('href') + '/' + board.fen() + ' b - - 0 1');
            });
            </script>
            @endif
          </div>
        </div>
      </div>
      @include('layout.partials.rules')
      @include('layout.partials.adsense')
      @include('layout.partials.fb')
    </main>
    @include('layout.partials.footer')
  </body>
</html>