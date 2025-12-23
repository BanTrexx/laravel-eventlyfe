<nav class="navbar navbar-expand-lg fixed-top shadow-sm custom-navbar">
  <div class="container">
    <a class="navbar-brand p-0" href="{{ route('home') }}">
      <img src="{{ asset('images/eventlyfe_1.png') }}" alt="EventLyfe Logo" height="50">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-lg-auto align-items-center text-center gap-2 py-3 py-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ Route::is('events.all') ? 'active' : '' }}" href="{{ route('events.all') }}">Cari Event</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
        </li>

        <li class="nav-item border-lg-end pe-lg-3 me-lg-2">
          <button id="darkModeToggle" class="btn btn-link nav-link d-flex align-items-center justify-content-center">
            <i class="bi bi-moon-stars-fill fs-5" id="themeIcon"></i>
          </button>
        </li>

        @guest
        <li class="nav-item">
          <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4 rounded-pill w-100 w-lg-auto">Masuk</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4 rounded-pill w-100 w-lg-auto">Daftar</a>
        </li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name) }}"
              alt="Avatar" class="rounded-circle" width="32" height="32">
            <span>{{ explode(' ', Auth::user()->full_name)[0] }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 {{ (session('theme') == 'dark') ? 'dropdown-menu-dark' : '' }}">
            <li>
              @if(Auth::user()->role->slug == 'admin')
              <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
              @elseif(Auth::user()->role->slug == 'organizer')
              <a class="dropdown-item" href="{{ route('organizer.dashboard') }}">Dashboard Organizer</a>
              @elseif(Auth::user()->role->slug == 'checker')
              <a class="dropdown-item" href="{{ route('checker.dashboard') }}">Dashboard Checker</a>
              @else
              <a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a>
              @endif
            </li>

            @if(Auth::user()->role->slug == 'user')
            <li><a class="dropdown-item" href="{{ route('my.tickets') }}">Tiket Saya</a></li>
            @endif

            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Keluar
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>