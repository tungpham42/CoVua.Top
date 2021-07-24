<header class="site-header shadow-lg fixed-top">
  <div class="container mx-auto">
    <div class="row align-items-center">
      <a class="navbar-brand mr-auto my-0" href="{{ url('/') }}"><img src="{{ URL::to('/') }}/img/app-icons/logo-chess.png" class="chess-logo" alt="chess logo"><h1 class="d-inline" style="font-size: inherit !important;"><strong>Cờ vua</strong></h1><span id="header-status"></span></a>
      <div class="menu-toggle open" title="Trình đơn"></div>
      <nav class="navbar py-0">
        <ul class="nav navbar-nav">
          <li class="pt-4">
            <a class="home" href="{{ url('/') }}"><i class="fal fa-home-lg-alt"></i> Trang chủ</a>
          </li>
          <li class="pt-4">
            <a class="setup" href="{{ url('/xep-co') }}"><i class="fal fa-camera-retro"></i> Xếp cờ</a>
          </li>
          <li class="pt-4">
            <a class="contact" href="{{ url('/lien-he') }}"><i class="fal fa-envelope"></i> Liên hệ</a>
          </li>
          <li class="pt-4">
            <a class="lang" href="{{ url($langUrl) }}"><i class="fal fa-language"></i> English</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>