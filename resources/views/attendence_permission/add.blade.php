@extends('layouts.apps')

@if(isset($logData))
@section('title', "Edit Logbook - Absensi Peserta Magang Tokabe")
@else
@section('title', "Tambah Logbook - Absensi Peserta Magang Tokabe")
@endif

@section('extend_style')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quill/dist/quill.snow.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.date.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.time.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
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
        <h4 class="page-title">Permohonan izin</h4>
        <div class="d-flex align-items-center">

        </div>
      </div>
      <div class="col-7 align-self-center">
        <div class="d-flex no-block justify-content-end align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{route('user.attendence')}}">Kehadiran</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{route('user.attendence.permissions')}}">Permohonan izin</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Tambah permohonan</li>
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
  <!-- Welcome back  -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card  bg-light no-card-border">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 col-md-6 my-3">
              <div class="d-flex align-items-center">
                <div class="m-r-10" style="font-size:2rem;">
                  <i class="ri-map-pin-time-line text-success"></i>
                </div>
                <div>
                  <h3 class="m-b-0">Waktu</h3>
                  <div>{{ date('l, d F Y') }}</div>
                  <x-live-clock />
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 my-3">
              <div class="text-right">
                @if ($attendenceTodayData->notif != false)
                  @if ($attendenceTodayData->notif['display'] == true && $attendenceTodayData->notif['text'] == 'Masuk' && $attendenceTodayData->profileStatus == true)
                    <div class="col-sm-12 col-md-8 col-lg-8 text-center ml-auto alert alert-success" role="alert">
                      Anda sudah melakukan absensi masuk, waktu pulang belum saatnya!
                    </div>
                  @elseif ($attendenceTodayData->notif['display'] == true && $attendenceTodayData->notif['text'] == "Keluar" &&
                  $attendenceTodayData->profileStatus == true)
                    <div class="col-sm-12 col-md-8 col-lg-8 text-center ml-auto alert alert-success" role="alert">
                      Anda sudah melakukan absensi hari ini!
                    </div>
                  @elseif($attendenceTodayData->notif['display'] == false && $attendenceTodayData->profileStatus == true)
                    <div class="col-sm-12 col-md-10 col-lg-10 text-center ml-auto alert alert-info" role="alert">
                      <span>Anda belum melakukan absensi hari ini!</span><a href="{{ route('user.attendences') }}" class="btn btn-info ml-2">Profiles</a>
                    </div>
                  @elseif($attendenceTodayData->profileStatus == false)
                    <div class="col-sm-12 col-md-10 col-lg-10 text-center ml-auto alert alert-success" role="alert">
                      <span>Silahkan isi profile dan photo terlebih dahulu!</span><a href="{{ route('profile.setting') }}" class="btn btn-info ml-2">Profiles</a>
                    </div>
                  @endif
                @else
                  <div class="col-sm-12 col-md-10 col-lg-10 text-center ml-auto alert alert-danger" role="alert">
                    <span>Absensi Error</span>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================== -->
  <!-- Table Logbook attendence -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" id="frmLogbook" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="alert alert-danger" id="error-area" style="display:none;">
              <h5>Error</h5>
              <hr>
              <ul id="error">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            <div class="row">
              <div class="col-12 mt-3 mb-3 ">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 text-right control-label col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}" disabled readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-3 text-right control-label col-form-label">Mulai tanggal</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control pickadate-datelimits" id="start_date" name="start_date" placeholder="Pilih tanggal mulai" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-3 text-right control-label col-form-label">Selesai tanggal </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control pickadate-datelimits" id="finish_date" name="finish_date" placeholder="Pilih tanggal selesai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="reason" class="col-sm-3 text-right control-label col-form-label">Alasan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Alasan izin">
                    </div>
                </div>
                <hr class="mb-4 mt-5">
                <div class="w-100 text-right">
                  <button class="btn btn-lg btn-success" id="submit_logbook" type="submit"><i class="ri-health-book-line"></i> {{ isset($logData) ? 'Update' : 'Tambah' }}</button>
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
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
<!--c3 JavaScript -->
<script src="{{ asset('assets/extra-libs/c3/d3.min.js')}}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js')}}"></script>
<script src="{{ asset('dist/js/pages/dashboards/dashboard3.js')}}"></script>

<script src="{{ asset('assets/libs/quill/dist/quill.min.js')}}"></script>

<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.date.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.time.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/legacy.js')}}"></script>
<script src="{{ asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  var toolbarOptions = [
    ['bold', 'italic', 'underline'], // toggled buttons
    ['code-block'],
    [{
      'list': 'ordered'
    }, {
      'list': 'bullet'
    }],
    [{
      'script': 'sub'
    }, {
      'script': 'super'
    }], // superscript/subscript
    [{
      'indent': '-1'
    }, {
      'indent': '+1'
    }], // outdent/indent
    [{
      'direction': 'rtl'
    }], // text direction
    ['clean'] // remove formatting button
  ];

  var activityEditor = new Quill('#activityEditor', {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions
    }
  });
  var obstacleEditor = new Quill('#obstacleEditor', {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions
    }
  });


  $(function(e) {
    dateNow = new Date();
    $('.pickadate-datelimits').pickadate({
      min: [dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate()],
      max: [dateNow.getFullYear() + 1, dateNow.getMonth(), dateNow.getDate()]
    });
  });

  // Convert bytes to size
  function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return 0;
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    return parseFloat((bytes / Math.pow(k, 2)).toFixed(dm));
}

  // Prepare Logbook
  $(document).ready(function(e) {
    $(function() {
      // Multiple images preview with JavaScript
      var ShowMultipleImagePreview = function(input, imgPreviewPlaceholder) {
        if (input.files) {
          var filesAmount = input.files.length;
          for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
              $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
            }
            reader.readAsDataURL(input.files[i]);
          }
        }
      };
      $('#images').on('change', function() {
        ShowMultipleImagePreview(this, 'div.show-multiple-image-preview');
      });
    });
  });
  // Simpan Logbook
  $('#submit_logbook').click((e) => {
    e.preventDefault();
    var formData = new FormData(document.getElementById('frmLogbook'));
    // Verifikasi gambar + add ke form data
    let TotalImages = $('#images')[0].files.length; //Total Images
    let images = $('#images')[0];
    var status = 0;
    var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
    for (let i = 0; i < TotalImages; i++) {
      if(!validImageTypes.includes(images.files[i].type)){
        swal("Tipe file yang anda upload salah!", "Pastikan file yang anda upload adalah file foto dengan ekstensi png, jpg/jpeg, dan png.", "error");
        status = 1;
        break;
      }
      else if(formatBytes(images.files[i].size) > 1){
        swal("Ukuran file foto terlalu besar!", "Pastikan ukuran setiap foto yang ingin anda upload tidak melebihi 1MB.", "error");
        status = 2;
        break;
      }
      else{
        formData.append('images' + i, images.files[i]);
      }
    }
    // add total gambar dan beberapa data ke form data
    formData.append('TotalImages', TotalImages);
    formData.append('activity', $('#activityEditor .ql-editor').html());
    formData.append('obstacles', $('#obstacleEditor .ql-editor').html());
    formData.append('duration', `${$('#activity_time').val()} ${$('input[name="time_type"]:checked').val()}`);
    formData.append('id', "{{ isset($logData) ? $logData->id : '' }}");

    if ($('#activity_time').val() == "") {
      swal("Durasi Pengerjaan kosong", "Pastikan anda mengisi durasi pengerjaan", "error");
    } else if(status == 0) {
      $.ajax({
        url: "{{ (isset($logData)) ? Route('user.logbook.update') : Route('user.logbook.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: () => {
          $('#submit_logbook').text("Waiting...");
          $('#submit_logbook').prop('disabled', true);
          console.log("masuk");
        },
        success: (data) => {
          $('#submit_logbook').html('<i class="ri-health-book-line"></i> {{ isset($logData) ? "Update" : "Tambah" }}');
          $('#submit_logbook').prop('disabled', false);
          if (data.success) {
            swal("Sukses", "Logbook berhasil {{ isset($logData) ? 'diperbarui' : 'ditambahkan' }}!", "success")
              .then(() => {
                location.href = "/logbook";
              });
          } else {
            swal("Error", data.msg, "error");
          }
        },
        error: function(err) {
          console.log("Meninggoy");
          console.warn(err.responseJSON.errors);
          $('#error-area').css('display', 'block');
          if (err.status == 422)
            $.each(err.responseJSON.errors, function(key, item) {
              $("#error").append("<li>" + key + ": " + item[0] + "</li>")
              console.log(key);
            });
        }
      });
    }
  });
</script>

@if(isset($logData))
<script type="text/javascript">
  // Load Activity and Obstacle to Their Editor
  $('#activityEditor .ql-editor').html("{!! $logData->activity !!}");
  $('#obstacleEditor .ql-editor').html("{!! $logData->obstacles !!}");
</script>
@endif
@endsection
