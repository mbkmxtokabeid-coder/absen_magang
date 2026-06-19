<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      @if (Auth::user() != null)
      <ul id="sidebarnav">
        @if (Route::has('login') && Auth::user()->role == 1)
          <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Personal</span></li>
          <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('user.attendence') }}"><i class="ri-gps-line"></i><span class="hide-menu">Absensi </span></a></li>
          <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('user.logbook') }}"><i class="ri-booklet-line"></i><span class="hide-menu">Logbook </span></a></li>
          <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('user.jobdesk') }}"><i class="ri-booklet-line"></i><span class="hide-menu">Jobdesk </span></a></li>
          <li class="" style="flex: 1 1 0;"></li>
          <li class="" style="flex: 1 1 0;"></li>
        @elseif (Route::has('login') && (Auth::user()->role == 0 || Auth::user()->role == 2))
          <!-- User Profile-->
          <li>
            <!-- User Profile-->
            <div class="user-profile dropdown m-t-20">
              <div class="user-pic">
                @if (Route::has('login') && Auth::user()->profile_photo_url != null)
                <span class="image-profile image-profile-60 rounded-circle" style="background-image:url({{ url(Auth::user()->profile_photo_url) }});"></span>
                @endif
              </div>
              <div class="user-content hide-menu m-t-10">
                <h5 class="m-b-10 user-name font-medium">{{ ucfirst(Auth::user()->name) }}</h5>
                <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ti-settings"></i>
                </a>
                <form method="POST" style="display:inline;" action="{{ route('logout') }}">
                  @csrf
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" title="Logout" class="btn btn-circle btn-sm">
                    <i class="ti-power-off"></i>
                  </a>
                </form>
                <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                  <a class="dropdown-item" href="{{ (Auth::user()->role != 2) ? route('profile.show') : route('supervisor.profile') }}">
                    <i class="ti-user m-r-5 m-l-5"></i>
                    My Profile
                  </a>
                  @if(Auth::user()->role != 2)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('profile.setting') }}">
                      <i class="ti-settings m-r-5 m-l-5"></i>
                      Account Setting
                    </a>
                  @endif
                </div>
              </div>
            </div>
            <!-- End User Profile-->
          </li>
          <!-- User Profile-->
          @if(Auth::user()->role == 0)
            <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Admin Management</span></li>
          @else
            <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Supervisor Management</span></li>
          @endif
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('dashboard') }}"><i class="ri-dashboard-line"></i><span class="hide-menu">Dashboard </span></a></li>
          @if (Auth::user()->role == 0)
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.attendence') }}"><i class="ri-gps-line"></i><span class="hide-menu">Kehadiran </span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.campus') }}"><i class="ri-building-2-line"></i><span class="hide-menu">Kampus </span></a></li>
            @if (Auth::user()->job_role == 'Direktur')
              <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.instruktur') }}"><i class="ri-building-2-line"></i><span class="hide-menu">Instruktur</span></a></li>
            @endif
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.supervisors') }}"><i class="ri-user-2-line"></i><span class="hide-menu">Dosen Pembimbing </span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.users') }}"><i class="ri-folder-user-line"></i><span class="hide-menu">Magang Aktif</span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.userselesai') }}"><i class="ri-folder-user-line"></i><span class="hide-menu">Magang Selesai</span></a></li>
            {{-- Start Tambah Menu --}}
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.jurusan') }}"><i class="ri-home-gear-line"></i><span class="hide-menu">Setting Jurusan</span></a></li>
            {{-- End Tambah Menu --}}
            <li class="" style="flex: 1 1 0;"></li>
          @endif
          @if(Auth::user()->role == 2)
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('supervisor.attendences') }}"><i class="ri-folder-user-line"></i><span class="hide-menu">Kehadiran </span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="{{ route('supervisor.users') }}"><i class="ri-folder-user-line"></i><span class="hide-menu">Peserta Magang </span></a></li>
          @endif
        {{-- <li class="" style="flex: 1 1 0;"></li> --}}
        @endif
      </ul>
      @endif
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
