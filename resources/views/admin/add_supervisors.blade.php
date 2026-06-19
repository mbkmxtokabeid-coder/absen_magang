@extends('layouts.apps')

@section('title', "Dashboard - Absensi Peserta Magang Tokabe")

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
        @if($mode === "add")
          <h4 class="page-title">Tambah Dosen Pembimbing</h4>
        @else
          <h4 class="page-title">Edit Dosen Pembimbing</h4>
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
                <a href="{{ route('admin.users') }}">Dosen Pembimbing</a>
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
          <h4 class="card-title">Data Umum Dosen Pembimbing</h4>
          <h6 class="card-subtitle">Silahkan masukkan data umum dosen pembimbing dan nantinya diharapkan peserta magang membantu mengisikan data yang lebih detail.</h6>
        </div>
        <hr>
        <form class="form-horizontal" method="POST" action="{{ $mode === 'edit' ? '/supervisors/update/'.$supervisor->user_id : '/supervisors/store'}}">
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
                <input type="text" class="form-control" id="name" name="nama" placeholder="Nama lengkap" value="{{ ($mode === "edit") ? $supervisor->user->name : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 text-right control-label col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ ($mode === "edit") ? $supervisor->user->email : '' }}">
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
              <label for="job_role" class="col-sm-3 text-right control-label col-form-label">Jabatan</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="job_role" name="job_role" placeholder="Jabatan saat ini" value="{{ ($mode === "edit") ? $supervisor->position : '' }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="campus" class="col-sm-3 text-right control-label col-form-label">Asal Kampus</label>
              <div class="col-sm-9">
                <select class="form-control" name="campus" id="campus" value="{{ ($mode === 'edit') ? $supervisor->campus->id : ''}}">
                  @if($mode === "add")
                    <option value=""selected disabled hidden>Asal Kampus</option>
                  @else
                    <option value=""disabled hidden>Asal Kampus</option>
                  @endif
                  @foreach($campuss as $campus)
                    <option value="{{ $campus->id }}" {{ ($mode === "edit") ? ($supervisor->campus_id == $campus->id) ? "selected" : "" : "" }}>{{ $campus->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone_number" class="col-sm-3 text-right control-label col-form-label">Nomor Handphone</label>
              <div class="col-sm-9">
                <input type="text" id="phone_number" name="phone_number" class="form-control phone-number-mask" placeholder="Silahkan isi nomor handphone anda" value="{{ ($mode === 'edit') ? $supervisor->phone_number : ''}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="whatsapp_number" class="col-sm-3 text-right control-label col-form-label">Nomor WhatsApp</label>
              <div class="col-sm-9">
                <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control phone-number-mask" placeholder="Silahkan isi nomor whatsapp anda" value="{{ ($mode === 'edit') ? $supervisor->whatsapp_number : ''}}">
              </div>
            </div>
          </div>
          <hr>
          <div class="card-body">
            <div class="form-group m-b-0 text-right">
              <button class="btn btn-dark waves-effect waves-light" id="back-to-supervisor">X</button>
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
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js')}}"></script>

<script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{ asset('dist/js/pages/forms/mask/mask.init.js')}}"></script>
<script>
  $(function(e) {
    $(".telp-number-mask").inputmask("999-9999-9999")
    $(".phone-number-mask").inputmask("+62 999-9999-99999")
  });

  $('#gen-pass').click((e) => {
    e.preventDefault();
    $('#password').prop('type', 'text');
    $('#password').val(getPassword(12, true));
    $('#password').focus();
  });

  $('#password').keypress((e) => {
    if ($('#password').attr('type') == "text") {
      $('#password').prop('type', 'password');
    }
  });

  $('#back-to-supervisor').click((e) => {
    e.preventDefault();
    location.href="/supervisors";
  })
</script>
@endsection
