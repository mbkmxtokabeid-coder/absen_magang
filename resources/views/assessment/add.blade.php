@extends('layouts.apps')

@if($assessment == null)
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
        <h4 class="page-title">Ubah Penilaian</h4>
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
              <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Row -->
  <div class="row">
    <form class="" action="/users/{{Str::slug(strtolower($user->name), '-') }}/{{$user->id}}/assessment/store" method="post">
      @csrf
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="col-12">
        <div class="card border-success">
          <div class="card-header bg-success">
            <h4 class="m-b-0 text-white">Data Diri Mahasiswa</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="fullname" class="col-sm-3 text-right control-label col-form-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="fullname" value="{{ucwords($user->name)}}" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="nim" class="col-sm-3 text-right control-label col-form-label">NIM</label>
                  <div class="col-sm-9">
                    <input type="text" name="nim" class="form-control" id="nim" placeholder="Nomor induk mahasiswa" value="{{ $assessment->nim }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="major" class="col-sm-3 text-right control-label col-form-label">Jurusan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="major" value="{{ucwords($user->major)}}" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="class" class="col-sm-3 text-right control-label col-form-label">Kelas</label>
                  <div class="col-sm-9">
                    <input type="text" name="class" class="form-control" id="class" placeholder="Kelas mahasiswa di kampus" value="{{ $assessment->class }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="semester" class="col-sm-3 text-right control-label col-form-label">Semester</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="semester" id="semester" value="{{ucwords($user->semester)}}" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="job_role" class="col-sm-3 text-right control-label col-form-label">Bidang pekerjaan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="job_role" value="{{ucwords($user->job_role)}}" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card border-success">
          <div class="card-header bg-success">
            <h4 class="m-b-0 text-white">Data Diri Pembimbing Lapangan</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="supervisor_fullname" class="col-sm-3 text-right control-label col-form-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="supervisor_fullname" value="{{ucwords(Auth::user()->name)}}" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="supervisor_job_role" class="col-sm-3 text-right control-label col-form-label">Jabatan</label>
                  <div class="col-sm-9">
                    <input type="text" id="supervisor_job_role" class="form-control" value="{{ucwords(Auth::user()->job_role)}}" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="supervisor_company" class="col-sm-3 text-right control-label col-form-label">Perusahaan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="supervisor_company" value="CV. Inti Grafika" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-group row">
                  <label for="supervisor_company_address" class="col-sm-3 text-right control-label col-form-label">Alamat perusahaan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="supervisor_company_address" value="Jl. Garuda No.27 A, Medan Sunggal, Kota Medan" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card border-success">
          <div class="card-header bg-success">
            <h4 class="m-b-0 text-white">Kepribadian</h4>
          </div>
          <div class="card-body div-striped-rows">
            @php
              $numPersonality = 1;
            @endphp

            @foreach ($questions as $question)
              @if ($question['type'] == "personality")
                <div class="form-group {{ $numPersonality == 1 ? "mt-3" : "" }} row">
                  <div class="col-12">
                    <label style="font-size:1.1rem;">{{$numPersonality++}}. {{$question['question']}}</label>
                  </div>
                  @foreach ($question['answer'] as $answer)
                    <div class="col-sm-12 col-md-3 col-lg-3">
                      <div class="custom-control custom-radio">
                        <input type="radio" id="{{$question['id'] . '_' . $answer['value']}}" name="{{$question['id']}}" class="custom-control-input" value="{{$answer['value']}}" required {{ ($assessment != null) ? (($assessment[$question['col']] == $answer['value']) ? 'checked' : '') : '' }}>
                        <label class="custom-control-label" for="{{$question['id'] . '_' . $answer['value']}}">{{ucfirst($answer['text'])}}</label>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card border-success">
          <div class="card-header bg-success">
            <h4 class="m-b-0 text-white">Teknis lapangan</h4>
          </div>
          <div class="card-body div-striped-rows">
            @php
              $numFields = 1;
            @endphp

            @foreach ($questions as $question)
              @if ($question['type'] == "field technical")
                <div class="form-group {{ $numFields == 1 ? "mt-3" : "" }} row">
                  <div class="col-12">
                    <label style="font-size:1.1rem;">{{$numFields++}}. {{$question['question']}}</label>
                  </div>
                  @foreach ($question['answer'] as $answer)
                    @if ($numFields >= 4 && $numFields < 8)
                      <div class="col-12 mb-2">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="{{$question['id'] . '_' . $answer['value']}}" name="{{$question['id']}}" class="custom-control-input" value="{{$answer['value']}}" required {{ ($assessment != null) ? (($assessment[$question['col']] == $answer['value']) ? 'checked' : '') : '' }}>
                          <label class="custom-control-label" for="{{$question['id'] . '_' . $answer['value']}}">{{ucfirst($answer['text'])}}</label>
                        </div>
                      </div>

                    @else
                      <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="{{$question['id'] . '_' . $answer['value']}}" name="{{$question['id']}}" class="custom-control-input" value="{{$answer['value']}}" required {{ ($assessment != null) ? (($assessment[$question['col']] == $answer['value']) ? 'checked' : '') : '' }}>
                          <label class="custom-control-label" for="{{$question['id'] . '_' . $answer['value']}}">{{ucfirst($answer['text'])}}</label>
                        </div>
                      </div>
                    @endif
                  @endforeach
                </div>
              @endif
            @endforeach
          </div>
          <div class="card-footer text-right">
            <button type="submit" name="btn_save" class="btn btn-lg btn-success"><i class="ri-save-line"></i> Simpan</button>
          </div>
        </div>
      </div>
    </form>
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
