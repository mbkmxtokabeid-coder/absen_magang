@extends('layouts.apps')

@section('title', "Tambah JobDesk Peserta Magang")

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
        <h4 class="page-title">JobDesk</span></h4>
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
          <form class="form-horizontal" id="jobDesk" enctype="multipart/form-data">
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
                <input type="hidden" id="userIdUnique" value="{{ Request::segment(2) }}" />
                <div id="pekerjaanEditor" class="editor-form">{!! $user -> jobdesk !!}</div>
                <hr class="my-4">
              </div>
                <hr class="mb-4">
                <div class="w-100 text-left">
                  <button name="masukjobdesk" class="btn btn-lg btn-success" id="submit_jobdesk" type="submit"><i class="ri-health-book-line"></i>Save</button>
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
  // $('#jobDesk').submit(function(e) {
  //      e.preventDefault();
  //      let formData = new FormData(this);
  //      console.log(formData);

  //      $.ajax({
          
  //      });
  // });
  $('#jobDesk').submit((e) => {
    e.preventDefault();
    var jobdesk = $('.ql-editor').html().replaceAll('</p><p>', '<br />').replaceAll('<p>','').replaceAll('</p>','');
    var userID = $('#userIdUnique')[0].value;
    // Verifikasi gambar + add ke form data
    // add total gambar dan beberapa data ke form data
    // jobdesk.append('jobDesk', $('#pekerjaanEditor .ql-editor').html());
    console.log(jobdesk);
    // $.ajaxSetup({
    //   headers: {
    //     'X-CSRF-TOKEN': '{{csrf_token()}}'
    //     // 'X-CSRF-TOKEN': $('form > input[name="_token"]').value
    //   }
    // });
    if ($('#activity_time').val() == "") {
      swal("Durasi Pengerjaan kosong", "Pastikan anda mengisi durasi pengerjaan", "error");
    } else if(status == 0) {
      $.ajax({
        url: "{{ Route('admin.jobdesk.tambah') }}",
        type: "POST",
        data: {
          jobdesk:jobdesk,
          userID:userID,
          _token:'{{csrf_token()}}'
      },
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

@if(isset($logData))
<script type="text/javascript">
  // Load Activity and Obstacle to Their Editor
  $('#pekerjaanEditor .ql-editor').html("{!! $logData->activity !!}");
  $('#obstacleEditor .ql-editor').html("{!! $logData->obstacles !!}");
</script>
@endif
@endsection