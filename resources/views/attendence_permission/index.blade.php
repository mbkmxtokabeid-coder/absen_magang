@extends('layouts.apps')

@section('title', "Logbook - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-5 align-self-center">
        <h4 class="page-title">Permohonan izin kehadiran</h4>
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
                <a href="{{ route('user.attendence') }}">Kehadiran</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Permohonan Izin</li>
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
  <!-- Presence Button  -->
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
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h4 class="card-title"></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              {{-- Filter berdasarkan : --}}
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
  $('#list_attendence_permission').DataTable({
    "columnDefs": [{
      "targets": 0,
      "type": "date-eu"
    }],
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });
  $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

  $('.dt-buttons').addClass('w-100 d-flex my-3');
  $('.dt-buttons').append('<button class="btn btn-success btn-add-users ml-auto" onclick="location.href=`{{route('user.attendence.permissions.add')}}`;"><i class="ri-health-book-line mr-1"></i>Tambah Permohonan Izin</button>');
</script>


@endsection
