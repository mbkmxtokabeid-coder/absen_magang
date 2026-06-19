@extends('layouts.apps')

@section('title', "Data Kehadiran Peserta Magang - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Welcome back  -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card  bg-light no-card-border">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="m-r-10" style="font-size:2rem;">
              <i class="ri-chat-quote-fill text-success"></i>
            </div>
            <div>
              <h3 class="m-b-0">Hello, {{ Auth::user()->name }}</h3>
              <span>{{date("l, d F Y")}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Presence Summery -->
  <!-- ============================================================== -->
  <div class="card-group">
    <!-- Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="m-r-10">
            <span class="btn btn-circle btn-lg bg-success">
              <i class="ri-user-star-line text-white"></i>
            </span>
          </div>
          <div>
            Disetujui
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $data->count->agree }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Card -->
    <!-- Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="m-r-10">
            <span class="btn btn-circle btn-lg btn-warning">
              <i class="ri-user-follow-line text-white"></i>
            </span>
          </div>
          <div>
            Pending
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $data->count->pending }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Card -->
    <!-- Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="m-r-10">
            <span class="btn btn-circle btn-lg bg-danger">
              <i class="ri-user-unfollow-line text-white"></i>
            </span>
          </div>
          <div>
            Tidak disetujui
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $data->count->disagree }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Card -->
  </div>

  <!-- ============================================================== -->
  <!-- Table user attendence -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h4 class="card-title">Daftar permohonan izin</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              {{-- Filter berdasarkan :
                                 --}}
            </div>
          </div>
          <div class="table-responsive">
            <table id="list_attendence_permission" class="table table-striped table-bordered display">
              <thead>
                <tr>
                  <th class="text-center">Nama</th>
                  <th class="text-center nowrap">Status</th>
                  <th class="text-center">Mulai dari</th>
                  <th class="text-center">Hingga</th>
                  <th class="text-center">Alasan</th>
                  <th class="text-center">Tanggal permohonan</th>
                  <th class="text-center">Tanggal perubahan</th>
                  <th class="text-center">-</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data->attendencePermissions as $attendencePermission)
                  <tr>
                    <td>{{ $attendencePermission->name }}</td>
                    <td class="text-center">
                      @if($attendencePermission->status == "Pending")
                        <span class="label label-warning nowrap" style="font-size:.9rem;">Pending</span>
                      @elseif($attendencePermission->status == "Disetujui")
                        <span class="label label-success nowrap" style="font-size:.9rem;">Disetujui</span>
                      @else
                        <span class="label label-danger nowrap" style="font-size:.9rem;">Tidak Disetujui</span>
                      @endif
                    </td>
                    {{-- <td>{{ $attendencePermission->status }}</td> --}}
                    <td class="">{{ date_format(date_create($attendencePermission->start_date), "l, j M Y") }}</td>
                    <td class="">{{ date_format(date_create($attendencePermission->finish_date), "l, j M Y") }}</td>
                    <td>{{ $attendencePermission->reason }}</td>
                    <td class="">{{ date_format(date_create($attendencePermission->created_at), "l, j M Y") }}</td>
                    <td class="">{{ $attendencePermission->updated_at != $attendencePermission->created_at ? date_format(date_create($attendencePermission->updated_at), "l, j M Y") : '-' }}</td>
                    {{-- <td><span class="attendence-date-time" onload="">{{ $attendenceNow->created_at == '-' ? $attendenceNow->created_at : date_format(date_create($attendenceNow->created_at), "H:i:s") }}</span></td>
                    <td>{{ $attendenceNow->login_late_reason }}</td>
                    <td><span class="attendence-date-time" onload="">{{ $attendenceNow->created_at == '-' ? $attendenceNow->created_at : date_format(date_create($attendenceNow->updated_at), "H:i:s") }}</span></td>
                    <td>{{ $attendenceNow->logout_late_reason }}</td>
                    <td><span class="attendence-date-time" onload="">{{ $attendenceNow->created_at == '-' ? $attendenceNow->created_at : date_format(date_create($attendenceNow->created_at), "l, j M Y") }}</span></td> --}}
                    <td class="text-center">
                        <a href="#" class="btn btn-info mr-2" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Setujui"><i class="ri-check-fill"></i></a>
                        <a href="#" class="btn btn-danger mr-2" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Tidak disetujui"><i class="ri-close-fill"></i></a>
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
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
{{-- <script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js')}}"></script> --}}
<script type="text/javascript">
  //=============================================//
  //    File export                              //
  //=============================================//
  $('#list_attendence_permission').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });
  $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
  function updatetimetext(datetimes) {
      $('.attendence-date-time').text(moment(datetimes))
  }
</script>

@endsection
