@extends('layouts.apps')

@section('title', "Profil $name - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/extra-libs/calendar/calendar.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/libs/jbox/dist/jBox.all.min.css')}}" rel="stylesheet">
<style media="screen">
  .nav-tabs .nav-item {
    margin-bottom: -3px !important;
  }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-5 align-self-center">
        <h4 class="page-title">Profile</h4>
      </div>
      <div class="col-7 align-self-center">
        <div class="d-flex no-block justify-content-end align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">User</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->

  <!-- ============================================================== -->
  <!-- Start Page Content -->
  <!-- ============================================================== -->
  <!-- Row -->
  <div class="row mt-3">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card">
        <div class="card-body">
          <center class="m-t-30">
            <span class="image-profile image-profile-150 rounded-circle" style="background-image:url({{ url($supervisor->user->profile_photo_url) }});"></span>
            <h4 class="card-title m-t-10">{{ ucfirst($supervisor->user->name) }}</h4>
            <h6 class="card-subtitle">Dosen Pembimbing</h6>
          </center>
        </div>
        <div>
          <hr>
        </div>
        <div class="card-body">
          <small class="text-muted">Email address </small>
          <h6>{{ $supervisor->user->email }}</h6>
          <small class="text-muted p-t-30 db">Tempat dan Tanggal Lahir</small>
          <h6>-</h6>
          <small class="text-muted p-t-30 db">Maps Alamat Domisili</small>
          <div class="map-box mb-2">
            @if(isset($profile))
            <iframe src="https://www.google.com/maps/place/{{ Str::slug($profile->address . ' ' . $profile->sub_district, '+') }}" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="card">
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content tabcontent-border">
            <div class="tab-pane p-20 show active" id="profile" role="tabpanel">
              <div class="">
                <h5 class="mb-4">Informasi dosen</h5>
                <div class="row">
                  <div class="col-md-5 col-sm-12">
                    Asal Perguruan Tinggi
                  </div>
                  <div class="col-md-7 col-sm-12">
                    <b>{{ $supervisor->campus->name }}</b>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-5 col-sm-12">
                    Jabatan
                  </div>
                  <div class="col-md-7 col-sm-12">
                    <b>{{ $supervisor->position }}</b>
                  </div>
                </div>
                <hr>
                <h5 class="mt-5 mb-4">Kontak</h5>
                <div class="row">
                  <div class="col-md-5 col-sm-12">
                    Nomor Handphone
                  </div>
                  <div class="col-md-7 col-sm-12">
                    <b><a href="tel:{{ $supervisor->phone_number != '-' ? $supervisor->phone_number : '' }}" class="text-success">{{ $supervisor->phone_number }}</a></b>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-5 col-sm-12">
                    Nomor WhatsApp
                  </div>
                  <div class="col-md-7 col-sm-12">
                    <b><a href="tel:{{ $supervisor->whatsapp_number != '-' ? $supervisor->whatsapp_number : ''}}" class="text-success">{{ $supervisor->whatsapp_number }}</a></b>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 text-right my-3">
                    <a href="{{ (Auth::user()->role != 2) ? route('admin.users') : route('supervisor.users') }}" class="btn btn-lg btn-info"><i class="ri-arrow-go-back-line"></i> Kembali</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
  </div>
  <!-- Row -->
  <!-- ============================================================== -->
  <!-- End PAge Content -->
  <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
<!--c3 JavaScript -->
<script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js')}}"></script>

<script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script src="{{ asset('assets/libs/moment/min/moment-with-locales.min.js')}}"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/libs/jbox/dist/jBox.all.min.js')}}"></script>
@endsection