@extends('layouts.auth')

@section('auth_content')
<!-- Login box.scss -->
<!-- ============================================================== -->
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../../assets/images/big/auth-bg.jpg) no-repeat center center;">
  <div class="auth-box">
    <div id="loginform">
      <div class="logo">
        <span class="db"><img src="{{asset('assets/images/Logo-TKB-Background-putih.png')}}" alt="logo" /></span>
        <h5 class="font-medium m-b-20 mt-2">Login untuk absensi </h5>
      </div>
      <!-- Form -->
      <div class="row">
        <div class="col-12">
          @if ($errors->any())
          <div class="alert alert-danger mb-4 text-sm text-danger" role="alert">
            <div class="font-medium text-red-600">{{ __('Whoops! Login gagal.') }}</div>
            <div class="">
              Email atau Password salah!
            </div>
          </div>
          @endif
          @if (session('status'))
          <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
          </div>
          @endif
          <form class="form-horizontal m-t-20" id="loginform" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="email-login"><i class="ti-email"></i></span>
              </div>
              <input type="email" name="email" class="form-control form-control-lg" placeholder="E-Mail" aria-label="E-Mail" aria-describedby="email-login" :value="old('email')" tabindex="1" required autofocus>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="pass-login"><i class="ti-key"></i></span>
              </div>
              <input type="password" name="password" id="password-login-text" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="pass-login" tabindex="2" required autocomplete="current-password">
              <div class="input-group-append">
                <button type="button" class="input-group-text" id="see-my-pass"><i class="ti-eye"></i></button>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-12">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Ingat saya</label>
                  <a href="{{ route('password.request') }}" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Lupa sandi?</a>
                </div>
              </div>
            </div>
            <div class="form-group text-center">
              <div class="col-xs-12 p-b-20">
                <button class="btn btn-block btn-lg btn-success" type="submit" type="submit" tabindex="3">Log In</button>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                <div class="footer text-center m-0">
                  <div class="">
                    Copyright &copy; 2021 by <a href="#" class="text-success">Tokabe.id</a </div>
                    <div class="">
                      Developed by <a href="{{route('teams')}}" class="text-success">IT Teams</a>.
                    </div>
                  </div>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- Login box.scss -->
<!-- ============================================================== -->


@endsection

@section('extend_script')
<script type="text/javascript">
  $(document).ready(function() {
    var passLook = false;
    $('#see-my-pass').click(function() {
      if (passLook == false) {
        $('#password-login-text').attr('type', 'text');
        $('#see-my-pass').addClass('bg-info text-light');
        passLook = true;
      } else {
        $('#password-login-text').attr('type', 'password');
        $('#see-my-pass').removeClass('bg-info text-light');
        passLook = false;
      }
    })
  })
</script>
@endsection
