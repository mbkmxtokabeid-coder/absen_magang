@extends('layouts.apps')

@section('title', "Dashboard - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/libs/morris.js/morris.css')}}" rel="stylesheet">
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
              <h3 class="m-b-0">Hello, {{ ucfirst(Auth::user()->name) }}</h3>
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
              <i class="ri-user-line text-white"></i>
            </span>
          </div>
          <div>
            Peserta Magang Aktif
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $userActiveCount }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="m-r-10">
            <span class="btn btn-circle btn-lg bg-success">
              <i class="ri-user-line text-white"></i>
            </span>
          </div>
          <div>
            Peserta Magang Selesai
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $userFinishCount }}</h2>
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
              <i class="ri-community-line text-white"></i>
            </span>
          </div>
          <div>
            Asal Kampus
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $campusCount }}</h2>
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
              <i class="ri-medal-2-line text-white"></i>
            </span>
          </div>
          <div>
            Bidang Pekerjaan
          </div>
          <div class="ml-auto">
            <h2 class="m-b-0 font-light">{{ $jobRoleCount }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Card -->
  </div>
  <!-- ============================================================== -->
  <!-- Presence Graph -->
  <!-- ============================================================== -->
  <div class="row">
    {{-- Graph --}}
    <div class="col-lg-8 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <h4 class="card-title">Kehadiran</h4>
              <h5 class="card-subtitle">Total kehadiran setiap bulan</h5>
            </div>
            <div class="ml-auto">
              <ul class="list-inline font-12 dl m-r-10">
                <li class="list-inline-item">
                  <i class="fas fa-dot-circle" style="color:#22c6ab"></i> Hadir Tepat Waktu
                </li>
                <li class="list-inline-item">
                  <i class="fas fa-dot-circle" style="color:#ffbc34"></i> Terlambat
                </li>
                <li class="list-inline-item">
                  <i class="fas fa-dot-circle" style="color:#d9153e"></i> Tidak Hadir
                </li>
              </ul>
            </div>
          </div>
          <div id="product-sales" style="height:305px"></div>
        </div>
      </div>
    </div>

    {{-- User presence --}}
    <div class="col-lg-4 col-sm-12">
      <div class="card earning-widget">
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              <h4 class="m-b-0">Hadir hari ini</h4>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('admin.attendence') }}" class="btn btn-sm btn-info text-right"><i class="ri-external-link-line"></i></i></a>
            </div>
          </div>
        </div>
        <div class="border-top scrollable" style="height:365px;overflow:auto;">
          <table class="table v-middle no-border">
            <tbody>
              @foreach ($attendenceData as $attendence)
              <tr>
                <td>
                  @if($attendence->profile_photo_path != null)
                  <span class="image-profile image-profile-50 rounded-circle" style="background-image:url({{'storage/'.$attendence->profile_photo_path}})"></span>
                  @else
                  <img src="{{ 'storage/profile-photos/2.png' }}" width="50" class="rounded-circle" alt="logo">
                  @endif
                </td>
                <td>{{ $attendence->name }}</td>
                <td align="right" class="col-7" style="padding-left:0;">
                  @if($attendence->status == "Tepat Waktu")
                  <span class="label label-success text-center">Hadir</span>
                  @elseif($attendence->status == "Terlambat")
                  <span class="label label-info nowrap">Terlambat</span>
                  @else
                  <span class="label label-danger">Belum Hadir</span>
                  @endif
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
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
<!--c3 JavaScript -->
<script src="{{ asset('assets/extra-libs/c3/d3.min.js')}}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js')}}"></script>
<script src="{{ asset('dist/js/pages/dashboards/dashboard3.js')}}"></script>

{{-- Chart Js --}}
<script src="{{ asset('assets/libs/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('assets/libs/morris.js/morris.min.js')}}"></script>

<script type="text/javascript">
  $(function() {
    'use strict';
    // ==============================================================
    // Product Sales
    // ==============================================================

    var graphData = "{{ json_encode($graphData->data) }}";
    graphData = JSON.parse(graphData.replace(/&quot;/g, '"'));
    console.log(graphData);

    var itemGraphData = [];
    for (var i = 0; i < graphData.length; i++) {
      itemGraphData.push({
        period: graphData[i].date,
        presence: graphData[i].data.attend,
        late: graphData[i].data.late,
        absence: graphData[i].data.notAttend
      });
    }
    console.log(itemGraphData);
    Morris.Area({
      element: 'product-sales',
      data: itemGraphData,
      xkey: 'period',
      ykeys: ['presence', 'late', 'absence'],
      labels: ['Hadir', 'Terlambat', 'Tidak Hadir'],
      pointSize: 2,
      fillOpacity: 0,
      pointStrokeColors: ['#22c6ab', '#ffbc34', '#d9153e'],
      behaveLikeLine: true,
      gridLineColor: '#e0e0e0',
      lineWidth: 2,
      hideHover: 'auto',
      lineColors: ['#22c6ab', '#ffbc34', '#d9153e'],
      resize: true
    });
  });
</script>

@endsection