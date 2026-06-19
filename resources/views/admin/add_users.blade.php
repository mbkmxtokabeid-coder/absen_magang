@extends('layouts.apps')

@if($mode == "add")
  @section('title', "Tambah Peserta Magang - Absensi Peserta Magang Tokabe")
@else
  @section('title', "Edit Peserta Magang - Absensi Peserta Magang Tokabe")
@endif

@section('extend_style')

@endsection

@section('content')
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb mb-5">
    <div class="row">
      <div class="col-5 align-self-center">
        <h4 class="page-title">Tambah peserta magang</h4>
        <div class="d-flex align-items-center">

        </div>
      </div>
      <div class="col-7 align-self-center">
        <div class="d-flex no-block justify-content-end align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Tambah data</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Row -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Umum Peserta magang</h4>
          <h6 class="card-subtitle">Silahkan masukkan data umum peserta magang dan nantinya peserta tersebut akan mengisikan data lengkap secara pribadi.</h6>
        </div>
        <hr>
        <form class="form-horizontal" method="POST" action="{{ $mode === 'edit' ? '/user/'.$user->id : '/users/store'}}">
          @csrf
          <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <div class="form-group row">
              <label for="name" class="col-sm-3 text-right control-label col-form-label">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="nama" placeholder="Nama lengkap" value="{{ ($mode === "edit") ? $user->name : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 text-right control-label col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ ($mode === "edit") ? $user->email : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-3 text-right control-label col-form-label">Password</label>
              <div class="col-sm-7">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              </div>
              <div class="col-sm-2">
                <button class="form-control btn btn-success waves-effect waves-light" id="gen-pass">Generate</button>
              </div>
            </div>
            <div class="form-group row">
              <label for="job_role" class="col-sm-3 text-right control-label col-form-label">Bidang Magang</label>
              <div class="col-sm-9">
                <select name="job_role" id="job_role" class="form-control">
                  @if($mode === "add")
                    <option value="" selected disabled hidden>Pilih bidang pada saat magang</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Bussiness Management">Bussiness Management</option>
                    <option value="Graphics Design">Graphics Design</option>
                    <option value="Multimedia">Multimedia</option>
                    <option value="IT Teams">IT Teams</option>
                    <option value="Office Administrator">Office Administrator</option>
                    <option value="Tax Accounting">Tax Accounting</option>
                    <option value="Web Programmer">Web Programmer</option>
                  @else
                    <option value="" disabled hidden>Pilih bidang pada saat magang</option>
                    <option value="Accounting" {{ $user->job_role === "Accounting" ? 'selected' : ''}}>Accounting</option>
                    <option value="Bussiness Management" {{ $user->job_role === "Bussiness Management" ? 'selected' : ''}}>Bussiness Management</option>
                    <option value="Graphics Design"  {{ $user->job_role === "Graphics Design" ? 'selected' : ''}}>Graphics Design</option>
                    <option value="Multimedia"  {{ $user->job_role === "Multimedia" ? 'selected' : ''}}>Multimedia</option>
                    <option value="IT Teams"  {{ $user->job_role === "IT Teams" ? 'selected' : ''}}>IT Teams</option>
                    <option value="Office Administrator"  {{ $user->job_role === "Office Administrator" ? 'selected' : ''}}>Office Administrator</option>
                    <option value="Tax Accounting" {{ $user->job_role === "Tax Accounting" ? 'selected' : ''}}>Tax Accounting</option>
                    <option value="Web Programmer"  {{ $user->job_role === "Web Programmer" ? 'selected' : ''}}>Web Programmer</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="supervisor" class="col-sm-3 text-right control-label col-form-label">Jurusan</label>
              <div class="col-sm-9">
                <select name="jurusan" id="jurusan" class="form-control">
                  @if($mode === "add")
                    <option value="" selected disabled hidden>Pilih Jurusan</option>
                    @foreach($jurusans as $jur)
                      <option value="{{ $jur->jurusanNama }}">{{ $jur->jurusanNama  }}</option>
                    @endforeach

                  @else
                  <option value="" disabled hidden>Pilih Jurusan</option>
                    @foreach ($jurusans as $jur)
                      <option value="{{ $jur->jurusanNama }}"
                      {{ isset($profile) && $profile->major == $jur->jurusanNama ? 'selected' : '' }}>{{ $jur->jurusanNama }}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="supervisor" class="col-sm-3 text-right control-label col-form-label">Dosen Pembimbing</label>
              <div class="col-sm-9">
                <select name="supervisor" id="supervisor" class="form-control">
                  @if($mode === "add")
                    <option value="" selected disabled hidden>Pilih dosen pembimbing</option>
                    @foreach($supervisors as $supervisor)
                      <option value="{{ $supervisor->user_id }}">{{ $supervisor->user->name . ' - ' . $supervisor->campus->name  }}</option>
                    @endforeach
                    
                  @else
                  <option value="" disabled hidden>Pilih dosen pembimbing</option>
                    @foreach($supervisors as $supervisor)
                      <option value="{{ $supervisor->user_id }}" {{ optional($user->profile)->supervisor_id == $supervisor->user_id ? 'selected' : 'x' }}>{{ $supervisor->user->name . ' - ' . $supervisor->campus->name  }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-body">
            <div class="form-group m-b-0 text-right">
              <button class="btn btn-dark waves-effect waves-light" id="back-to-users">X</button>
              <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
              @if($mode === "edit")
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Row -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
  <script src="{{ asset('dist/js/passwordGenerator.min.js') }}"></script>
  <script>
    $('#back-to-users').click((e) => {
      e.preventDefault();
      location.href = '/users';
    });
    $('#gen-pass').click((e) => {
      e.preventDefault();
      $('#password').prop('type', 'text');
      $('#password').val(getPassword(12, true));
      $('#password').focus();
    });

    $('#password').keypress((e) => {
      if($('#password').attr('type') == "text"){
        $('#password').prop('type', 'password');
      }
    });
  </script>
@endsection
