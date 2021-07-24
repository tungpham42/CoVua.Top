<header class="site-header shadow-lg fixed-top">
  <div class="container mx-auto">
    <div class="row align-items-center">
      <a class="navbar-brand mr-auto my-0" href="{{ url('/en') }}"><img src="{{ URL::to('/') }}/img/app-icons/logo-chess.png" class="chess-logo" alt="chess logo"><h1 class="d-inline" style="font-size: inherit !important;"><strong>Chess</strong></h1><span id="header-status"></span></a>
      <div class="menu-toggle open" title="Menu"></div>
      <nav class="navbar py-0">
        <ul class="nav navbar-nav">
          <li class="pt-4">
            <a class="home" href="{{ url('/en') }}"><i class="fal fa-home-lg-alt"></i> Home</a>
          </li>
          <li class="pt-4">
            <a class="setup" href="{{ url('/set-up') }}"><i class="fal fa-camera-retro"></i> Set Up</a>
          </li>
          <li class="pt-4">
            <a class="contact" href="{{ url('/contact-us') }}"><i class="fal fa-envelope"></i> Contact Us</a>
          </li>
          <li class="pt-4">
            <a class="lang" href="{{ url($langUrl) }}"><i class="fal fa-language"></i> Tiếng Việt</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>