<header class="topbar">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header d-flex align-items-center justify-content-between px-3" data-logobg="skin3" style="width: 100% !important;">
      <!-- Sidebar toggle for mobile -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
        <i class="ti-menu ti-close"></i>
      </a>
      <!-- Logo -->
      <a class="navbar-brand" href="{{route('dashboard')}}">
        <b class="logo-icon">
          <img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="homepage" class="dark-logo" style="max-height:30px!important;" />
          <img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="homepage" class="light-logo" style="max-height:30px!important" />
        </b>
        <span class="logo-text"></span>
      </a>

      <!-- Mobile Profile Dropdown (Only visible on mobile d-md-none) -->
      <div class="d-block d-md-none">
        @if (Auth::user() != null)
        <div class="dropdown">
          <a class="dropdown-toggle text-muted waves-effect waves-dark pro-pic link-image-profile d-flex align-items-center" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ Auth::user()->profile_photo_url }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF';" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #ffffff;" />
          </a>
          <div class="dropdown-menu dropdown-menu-right user-dd animated fadeInDown">
            <span class="with-arrow"><span class="bg-primary"></span></span>
            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
              <div>
                <img src="{{ Auth::user()->profile_photo_url }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF';" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" />
              </div>
              <div class="m-l-10">
                <h4 class="m-b-0">{{ ucfirst(Auth::user()->name) }}</h4>
                <p class="m-b-0" style="font-size:12px; line-height: 1 !important;">{{ Auth::user()->email }}</p>
              </div>
            </div>
            <a class="dropdown-item" href="{{ (Auth::user()->role != 2) ? route('profile.show') : route('supervisor.profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
            @if(Auth::user()->role != 2)
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('profile.setting') }}"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
            @endif
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
            </form>
          </div>
        </div>
        @else
        <a href="{{route('login')}}" class="text-white">Login</a>
        @endif
      </div>
    </div>

    <!-- Desktop Navbar Collapse (Only visible on Desktop d-none d-md-flex) -->
    <div class="navbar-collapse collapse d-none d-md-flex" id="navbarSupportedContent" style="width: 100%;">
      <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item">
          <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
            <i class="sl-icon-menu font-20"></i>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav float-right ml-auto d-flex align-items-center">
        <li class="nav-item dropdown">
          @if (Auth::user() != null)
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic link-image-profile d-flex align-items-center" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ Auth::user()->profile_photo_url }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF';" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover; border: 2px solid #ffffff;" />
          </a>
          <div class="dropdown-menu dropdown-menu-right user-dd animated fadeInDown">
            <span class="with-arrow"><span class="bg-primary"></span></span>
            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
              <div>
                <img src="{{ Auth::user()->profile_photo_url }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF';" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" />
              </div>
              <div class="m-l-10">
                <h4 class="m-b-0">{{ ucfirst(Auth::user()->name) }}</h4>
                <p class="m-b-0">{{ Auth::user()->email }}</p>
              </div>
            </div>
            <a class="dropdown-item" href="{{ (Auth::user()->role != 2) ? route('profile.show') : route('supervisor.profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
            @if(Auth::user()->role != 2)
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('profile.setting') }}"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
            @endif
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
            </form>
          </div>
          @else
          <a class="nav-link text-light waves-effect waves-dark" href="{{route('login')}}"><i class="mdi mdi-login mr-1"></i>Login</a>
          @endif
        </li>
      </ul>
    </div>
  </nav>
</header>