{{--

  === HEADER COMPONENT ===

--}}

<header class="container-fluid bg-dark fixed-top c-header">
  <nav class="navbar navbar-expand-lg navbar-dark" role="navigation">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="{{ asset('img/reclame-ali-white.png') }}" width="30" height="30" class="d-inline-block align-top" alt="Logo do sistema" />
      <span class="text-white-50 h4 c-title">Reclame Ali</span>
    </a>
    <div class="container">
      <ul class="navbar-nav text-white">
        @foreach(auth()->user()->getNavigationLinks() as $link)
          <li class="nav-item">
            <a href="{{ route($link['route']) }}" class="nav-link {{ active($link['route']) }}">
              {{ $link['label'] }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
    <form action="{{ route('auth.signout') }}" method="POST" class="form-inline">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger text-white my-2 my-sm-0">
        <i class="fas fa-door-open"></i>
        Sair
      </button>
    </form>
  </nav>
</header>
