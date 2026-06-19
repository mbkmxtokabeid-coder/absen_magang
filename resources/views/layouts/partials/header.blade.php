<header class="topbar">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header" data-logobg="skin3">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
        <i class="ti-menu ti-close"></i>
      </a>
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <a class="navbar-brand" href="{{route('dashboard')}}">
        <!-- Logo icon -->
        <b class="logo-icon">
          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
          <!-- Dark Logo icon -->
          <img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="homepage" class="dark-logo" style="max-height:30px!important;" />
          <!-- Light Logo icon -->
          <img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="homepage" class="light-logo" style="max-height:30px!important" />
        </b>
        <!--End Logo icon -->
        <!-- Logo text -->
        <span class="logo-text">
          {{-- <h4 class="text-light">Absensi IB TKB</h4> --}}
          <!-- dark Logo text -->
          <!--<img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="homepage" class="dark-logo" style="max-height:30px!important" />-->
          <!-- Light Logo text -->
          <!--<img src="{{ asset('assets/images/Logo-TKB-Background-putih.png')}}" class="light-logo" alt="homepage" style="max-height:30px!important" />-->
        </span>
      </a>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      {{-- <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a> --}}
      <li class="nav-item dropdown d-md-none ">
        @if (Auth::user() != null)
        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic link-image-profile" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if (Route::has('login') && Auth::user()->profile_photo_url != null)
          <span class="image-profile image-profile-31 rounded-circle" style="background-image:url({{ url(Auth::user()->profile_photo_url) }});"></span>
          @endif


        </a>
        <div class="dropdown-menu dropdown-menu-right user-dd animated fadeInRight">
          <span class="with-arrow">
            <span class="bg-primary"></span>
          </span>
          <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
            <div class="">
              @if (Route::has('login') && Auth::user()->profile_photo_url != null)
              <span class="image-profile image-profile-60 img-circle" style="background-image:url({{ url(Auth::user()->profile_photo_url) }});"></span>
              @endif
            </div>
            <div class="m-l-10">
              <h4 class="m-b-0">{{ ucfirst(Auth::user()->name) }}</h4>
              <p class=" m-b-0" style="line-height:1!important;">{{ Auth::user()->email }}</p>
            </div>
          </div>
          <a class="dropdown-item" href="{{ (Auth::user()->role != 2) ? route('profile.show') : route('supervisor.profile') }}">
            <i class="ti-user m-r-5 m-l-5"></i> My Profile
          </a>
          @if(Auth::user()->role != 2)
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('profile.setting') }}">
              <i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
          @endif
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
              <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout
            </a>
          </form>
        </div>
        @else
        <a href="{{route('login')}}">Login</a>
        @endif
      </li>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item d-none d-md-block">
          <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
            <i class="sl-icon-menu font-20"></i>
          </a>
        </li>
      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->

      <ul class="navbar-nav float-right">
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          @if (Auth::user() != null)
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic link-image-profile" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if (Route::has('login') && Auth::user()->profile_photo_url != null)
            <span class="image-profile image-profile-31 rounded-circle" style="background-image:url({{ url(Auth::user()->profile_photo_url) }});"></span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right user-dd animated fadeInDown">
            <span class="with-arrow">
              <span class="bg-primary"></span>
            </span>
            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
              <div class="">
                @if (Route::has('login') && Auth::user()->profile_photo_url != null)
                <span class="image-profile image-profile-60 img-circle" style="background-image:url({{ url(Auth::user()->profile_photo_url) }});"></span>
                @endif
              </div>
              <div class="m-l-10">
                <h4 class="m-b-0">{{ ucfirst(Auth::user()->name) }}</h4>
                <p class=" m-b-0">{{ Auth::user()->email }}</p>
              </div>
            </div>
            <a class="dropdown-item" href="{{route('profile.show')}}">
              <i class="ti-user m-r-5 m-l-5"></i> My Profile
            </a>
            @if(Auth::user()->role != 2)
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('profile.setting') }}">
                <i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
            @endif
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout
              </a>
            </form>
          </div>
          @else
          <a class="nav-link text-light waves-effect waves-dark " href="{{route('login')}}">
            <i class="mdi mdi-login mr-1"></i>Login
          </a>
          @endif
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
</header>