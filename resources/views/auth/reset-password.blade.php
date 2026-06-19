@extends('layouts.auth')

@section('auth_content')
  <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../../assets/images/big/auth-bg.jpg) no-repeat center center;">
    <div class="auth-box">
      <div>
        <div class="logo">
          <span class="db"><img src="{{asset('assets/images/logo-intigrafika.png')}}" alt="logo" /></span>
          <h5 class="font-medium m-b-20 mt-2">Recover Kata Sandi</h5>
        </div>
        <!-- Form -->
        @if (session('status'))
          <div class="row">
            <div class="alert alert-success col-12">
              {{ session('status') }}
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-12">
            <form method="POST" action="{{ route('password.update') }}">
              @csrf

              <input type="hidden" name="token" value="{{ $request->route('token') }}">

              <div class="form-group row">
                <div class="col-12">
                  <input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Email" :value="old('email', $request->email)" required autofocus tabindex="1">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12">
                  <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Kata Sandi" required autocomplete="new-password" tabindex="2">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12">
                  <input class="form-control form-control-lg" type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password" tabindex="3">
                </div>
              </div>

              <div class="form-group text-center">
                <div class="col-xs-12 p-b-20">
                  <button class="btn btn-block btn-lg btn-info" type="submit" tabindex="4">
                    <i class="ri-mail-send-line mr-1"></i>
                    Reset Kata Sandi
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extend_script')

@endsection
