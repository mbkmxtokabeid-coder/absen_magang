@extends('layouts.apps')

@if(isset($jobData))
@section('title', "Edit Jobdesk - Absensi Peserta Magang Tokabe")
@else
@section('title', "Tambah Jobdesk - Absensi Peserta Magang Tokabe")
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
        <h4 class="page-title">Jobdesk</span></h4>
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
              <li class="breadcrumb-item active" aria-current="page">Magang Aktif</li>
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
  <!-- ============================================================== -->
  <!-- Table Logbook attendence -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" id="jobDesk" method="POST" enctype="multipart/form-data">
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
              <div class="col-sm-12 col-md-8 col-lg-8">
                <h5 class="">Pekerjaan</h5>
                <!-- Create the editor container -->
                <input type="hidden" id="userIdUnique" name="userIdUnique" value="{{ Request::segment(3) }}" />
                <div id="pekerjaanEditor" class="editor-form"></div>
                <hr class="my-4">
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
              <label for="from"><h5 class="">Pekerjaan Dari</h5></label>
                <div class="mb-4">
                  <select id="from" name="from" class="form-control">
                    <option value="" selected disabled hidden>Pilih Jabatan Anda</option>
                    <option value="Mentor / Instruktur">Mentor / Instruktur</option>
                    <option value="Dosen Pembimbing">Dosen Pembimbing</option>
                  </select>
                </div>

                <hr class="mb-4">
                <h5 class="">Tanggal Pemberian Jobdesk</h5>
                <div class="mb-4">
                  <input type="text" class="form-control pickadate-datelimits" id="actual_date" name="actual_date" placeholder="Pilih tanggal aktual" value="{{ isset($jobData) ? date('d F, Y', strtotime($jobData->date)) : '' }}">
                </div>

                <hr class="mb-5">
                <h5 class="">Durasi pengerjaan</h5>
                <div class="mb-3">
                  <input type="number" class="form-control" id="activity_time" name="activity_time" placeholder="Waktu pengerjaan aktivitas" value="{{ isset($jobData) ? $jobData->duration[0] : '' }}">
                </div>
                <div class="mb-4 d-flex justify-content-around">
                  <div class="flex-grow-1 text-center">
                    <label for="time_type_day">
                      <input type="radio" name="time_type" id="time_type_day" value="Hari" {{ isset($jobData) ? ($jobData->duration[1] == "Hari") ? 'checked' : '' : '' }}>
                      Hari
                    </label>
                  </div>
                  <div class="flex-grow-1 text-center">
                    <label for="time_type_week">
                      <input type="radio" name="time_type" id="time_type_week" value="Minggu" {{ isset($jobData) ? ($jobData->duration[1] == "Minggu") ? 'checked' : '' : ''}}>
                      Minggu
                    </label>
                  </div>
                  <div class="flex-grow-1 text-center">
                    <label for="time_type_month">
                      <input type="radio" name="time_type" id="time_type_month" value="Bulan" {{ isset($jobData) ? ($jobData->duration[1] == "Bulan") ? 'checked' : '' : '' }}>
                      Bulan
                    </label>
                  </div>
                </div>
              </div>
              <hr class="mb-4">
              <div class="w-100 text-left">
                <button name="submit_jobdesk" class="btn btn-lg btn-success" id="submit_jobdesk" type="submit"><i class="ri-health-book-line"></i>Save</button>
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

  var pekerjaanEditor = new Quill('#pekerjaanEditor', {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions
    }
  });

  $(function(e) {
    dateNow = new Date();
    $('.pickadate-datelimits').pickadate({
      min: [2020, 1, 1],
      max: [dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate()]
    });
  });

  // Convert bytes to size
  function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return 0;
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    return parseFloat((bytes / Math.pow(k, 2)).toFixed(dm));
  }
  // Simpan Logbook
  // $('#jobDesk').submit(function(e) {
  //      e.preventDefault();
  //      let formData = new FormData(this);
  //      console.log(formData);

  //      $.ajax({
          
  //      });
  // });
  $('#submit_jobdesk').click((e) => {
    e.preventDefault();
    // var jobdesk = $('.ql-editor').html().replaceAll('</p><p>', '<br />').replaceAll('<p>','').replaceAll('</p>','');
    var userID = $('#userIdUnique')[0].value;
    var status = 0;
    var formData = new FormData(document.getElementById('jobDesk'));
    // var job_activity = $('#pekerjaanEditor .ql-editor').html();
    // var activity_time = $('#activity_time').val();
    // var durasi = `${$('#activity_time').val()} ${$('input[name="time_type"]:checked').val()}`;
    // var actual_date = $('#actual_date').val();
    // var from = $('#from').val();
    // Verifikasi gambar + add ke form data
    // add total gambar dan beberapa data ke form data
    formData.append('job_activity', $('#pekerjaanEditor .ql-editor').html());
    formData.append('pekerjaan_dari', $('#from').val());
    formData.append('durasi', `${$('#activity_time').val()} ${$('input[name="time_type"]:checked').val()}`);
    formData.append('id', "{{ isset($jobData) ? $jobData->id : '' }}");
    // jobdesk.append('jobDesk', $('#pekerjaanEditor .ql-editor').html());
    // console.log(userID);
    // console.log(job_activity);
    // // console.log(activity_time);
    // console.log(durasi);
    // console.log(actual_date);
    // console.log(from);
    // $.ajaxSetup({
    //   headers: {
    //     'X-CSRF-TOKEN': '{{csrf_token()}}'
    //     //  'X-CSRF-TOKEN': $('form > input[name="_token"]').value
    //   }
    // });
    if ($('#activity_time').val() == "") {
      swal("Durasi Pengerjaan kosong", "Pastikan anda mengisi durasi pengerjaan", "error");
    } else if(status == 0) { 
      // console.log(formData);
      $.ajax({
        url: "{{  Route('admin.jobdesk.store') }}",
        type: "POST",
        data:formData,
        contentType: false,
        processData: false,
        beforeSend: () => {
          $('#submit_jobdesk').text("Waiting...");
          $('#submit_jobdesk').prop('disabled', true);
          console.log("masuk");
        },
        success: (data) => {
          $('#submit_jobdesk').html('<i class="ri-health-book-line"></i> Tambah');
          $('#submit_jobdesk').prop('disabled', false);
          if (data.success) {
            swal("Sukses", "JobDesk berhasil ditambahkan!", "success")
              .then(() => {
                location.href = "/users";
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
    };
  });
</script>

@if(isset($jobData))
<script type="text/javascript">
  // Load Activity and Obstacle to Their Editor
  $('#pekerjaanEditor .ql-editor').html("{!! $jobData->activity !!}");
</script>
@endif
@endsection