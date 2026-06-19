@extends('layouts.apps')

@if($mode == "add")
  @section('title', "Tambah Data Kampus - Absensi Peserta Magang Tokabe")
@else
  @section('title', "Edit Data Kampus - Absensi Peserta Magang Tokabe")
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
        @if ($mode == "add")
          <h4 class="page-title">Tambah Data Kampus</h4>
        @else
          <h4 class="page-title">Edit Data Kampus</h4>            
        @endif
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
                <a href="{{ route('admin.users') }}">Kampus</a>
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
          <h4 class="card-title">Data Umum Kampus</h4>
        </div>
        <hr>
        <form class="form-horizontal" method="POST" action="{{ $mode === 'add' ? '/campus/store' : '/campus/update/'. $campus->id }}">
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
              <label for="name" class="col-sm-3 text-right control-label col-form-label">Nama Kampus</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="nama" placeholder="Nama lengkap" value="{{ ($mode === "edit") ? $campus->name : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 text-right control-label col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ ($mode === "edit") ? $campus->email : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="telp_number" class="col-sm-3 text-right control-label col-form-label">Nomor Telp</label>
              <div class="col-sm-9">
                <input type="text" id="telp_number" name="telp_number" class="form-control telp-number-mask" placeholder="Silahkan isi nomor telepon anda" value="{{  ($mode === "edit") ? $campus->telp : ''}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-3 text-right control-label col-form-label">Alamat</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="address" name="address" placeholder="Alamat lengkap" style="resize:none;" rows="3">{{ ($mode === "edit") ? $campus->address : '' }}</textarea>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-body">
            <div class="form-group m-b-0 text-right">
              <button class="btn btn-dark waves-effect waves-light" id="back-to-campus">X</button>
              <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
              @if($mode === "edit")
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

    $('#back-to-campus').click((e) => {
      e.preventDefault();
      location.href = '/campus';
    })
  </script>
@endsection
