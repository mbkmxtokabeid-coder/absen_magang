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
              <li class="breadcrumb-item active" aria-current="page">User Jobdesk</li>
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
            @foreach($users as $user)
            <div class="row display">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <h5 class="">Pekerjaan dari Mentor</h5>
                <!-- Create the editor container -->
                <div id="pekerjaanEditorMentor" class="editor-form">{!! $user -> jobdesk !!}</div>
                <hr class="my-4">
              </div>
                <hr class="mb-4">
                <div class="col-sm-12 col-md-8 col-lg-8">
                <h5 class="">Pekerjaan dari Doping</h5>
                <!-- Create the editor container -->
                <div id="pekerjaanEditorDoping" class="editor-form">{!! $user -> jobdeskSup !!}</div>
            @endforeach   
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
  var pekerjaanEditor = new Quill('#pekerjaanEditorMentor', {
    theme: 'snow'
  });
  var pekerjaanEditorDoping = new Quill('#pekerjaanEditorDoping', {
      theme: 'snow'
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
  
</script>

@if(isset($logData))
<script type="text/javascript">
  // Load Activity and Obstacle to Their Editor
  $('#pekerjaanEditor .ql-editor').html("{!! $logData->activity !!}");
  $('#obstacleEditor .ql-editor').html("{!! $logData->obstacles !!}");
</script>
@endif
@endsection