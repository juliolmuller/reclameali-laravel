{{--

  === HEADER COMPONENT ===

  Expected parameters:
    $navigationLinks : array (optional)
    $activePage      : int   (optional)

--}}

<header class="container-fluid bg-dark fixed-top c-header">
  <nav class="navbar navbar-expand-lg navbar-dark" role="navigation">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ url('/img/reclame-ali-white.png') }}" width="30" height="30" class="d-inline-block align-top" alt="Logo do sistema" />
      <span class="text-white-50 h4 c-title">Reclame Ali</span>
    </a>
    <div class="container">
      @isset($navigationLinks)
        <ul class="navbar-nav text-white">
          @foreach ($navigationLinks as $nav)
            <li class="nav-item">
              <a href="{{ $nav['href'] }}" class="nav-link {{ isset($activePage) && $activePage == $loop->iteration ? 'active' : '' }}">
                {{ $nav['label'] }}
              </a>
            </li>
          @endforeach
        </ul>
      @endisset
    </div>
    <div class="form-inline">
      <a href="{{ url('/sair') }}" class="btn btn-sm btn-outline-danger text-white my-2 my-sm-0">
        <i class="fas fa-door-open"></i>
        Sair
      </a>
    </div>
  </nav>
</header>
