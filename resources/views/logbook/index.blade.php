@extends('layouts.apps')

@section('title', "Logbook - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
<style>
  .table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    width: 100%;
  }
  #list_logbook_today {
    width: 100% !important;
    min-width: 800px !important;
  }
  #list_logbook_today td {
    vertical-align: top !important;
    word-wrap: break-word;
    white-space: normal;
  }
  #list_logbook_today td h1, 
  #list_logbook_today td h2, 
  #list_logbook_today td h3, 
  #list_logbook_today td h4, 
  #list_logbook_today td h5, 
  #list_logbook_today td h6 {
    font-size: 0.95rem !important;
    font-weight: 700 !important;
    margin-top: 6px !important;
    margin-bottom: 4px !important;
    color: #333;
  }
  #list_logbook_today td p, 
  #list_logbook_today td ul, 
  #list_logbook_today td ol {
    font-size: 0.875rem !important;
    margin-bottom: 6px !important;
    padding-left: 20px;
  }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Welcome back  -->
  <!-- ============================================================== -->
  @if ($attendenceStatus == "success")
  <x-user-welcome />
  @else
  <x-user-welcome-not-login />
  @endif
  <!-- ============================================================== -->
  <!-- Table Logbook attendence -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h4 class="card-title">Logbook</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              {{-- Filter berdasarkan : --}}
            </div>
          </div>
          <div class="table-responsive">
            <table id="list_logbook_today" class="table table-striped table-hover table-bordered display">
              <thead>
                <tr>
                  <th class="text-center" style="width: 14%; min-width: 120px;">Tanggal</th>
                  <th class="text-center" style="width: 8%; min-width: 80px;">Status</th>
                  <th class="text-center" style="width: 36%; min-width: 240px;">Aktivitas</th>
                  <th class="text-center" style="width: 10%; min-width: 90px;">Durasi</th>
                  <th class="text-center" style="width: 24%; min-width: 200px;">Masalah</th>
                  <th class="text-center" style="width: 8%; min-width: 80px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($logbooks as $logbook)
                @php
                  $time = !empty($logbook->date) ? strtotime($logbook->date) : 0;
                  $validDate = ($time > 0 && date('Y', $time) > 1975);
                @endphp
                <tr>
                  <td data-sort="{{ $validDate ? date('Y-m-d', $time) : '1970-01-01' }}" class="align-middle">{{ $validDate ? date('l, d F Y', $time) : '-' }}</td>
                  <td class="align-middle">{{ $logbook->job_status }}</td>
                  <td>{!! $logbook->activity !!}</td>
                  <td class="align-middle">{{ $logbook->duration }}</td>
                  <td>{!! $logbook->obstacles !!}</td>
                  <td class="align-middle text-center">
                    <button class="btn btn-info mr-1 btn-edit" data-id="{{ $logbook->id }}" onclick="location.href='/logbook/edit/{{ $logbook->id }}'" data-toggle="tooltip" data-placement="top" title="Edit Logbook"><i class="ti-pencil-alt"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
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

<script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/extra-libs/datatables.net/js/date-eu.js')}}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js')}}"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  //=============================================//
  //    File export                              //
  //=============================================//
  // dt-buttons
  $('#list_logbook_today').DataTable({
    "autoWidth": false,
    "order": [[0, "asc"]],
    "columnDefs": [
      { "targets": 0, "width": "15%" },
      { "targets": 1, "width": "8%" },
      { "targets": 2, "width": "35%" },
      { "targets": 3, "width": "10%" },
      { "targets": 4, "width": "24%" },
      { "targets": 5, "width": "8%" }
    ],
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });
  $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

  $('.dt-buttons').addClass('w-100 d-flex my-3');
  $('.dt-buttons').append('<button class="btn btn-success btn-add-users ml-auto" onclick="location.href=`/logbook/add`;"><i class="ri-health-book-line mr-1"></i>Isi Logbook</button>');
</script>


@endsection
