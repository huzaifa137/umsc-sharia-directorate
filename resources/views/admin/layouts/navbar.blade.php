<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="container-fluid">
    <button class="btn btn-outline-secondary" id="menu-toggle">☰</button>
    <div class="navbar-nav ms-auto">
      @auth
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
          </ul>
        </div>
      @else
        <a href="{{ route('user.login') }}" class="btn btn-sm btn-outline-primary">Login</a>
      @endauth
    </div>
  </div>
</nav>