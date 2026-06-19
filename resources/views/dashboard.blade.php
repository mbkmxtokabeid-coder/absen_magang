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
                            <div class="m-r-10">
                                <img src="{{ asset('assets/images/users/2.jpg')}}" alt="user" width="60" class="rounded-circle" />
                            </div>
                            <div>
                                <h3 class="m-b-0">Welcome back!</h3>
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>86%</h3>
                            <h6 class="card-subtitle">Kehadiran</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>40%</h3>
                            <h6 class="card-subtitle">Terlambat</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 40%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>56%</h3>
                            <h6 class="card-subtitle">Total Absen</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- ============================================================== -->
        <!-- Presence Graph -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
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
                                      <i class="fas fa-dot-circle text-info"></i> Hadir Tepat Waktu
                                  </li>
                                  <li class="list-inline-item">
                                      <i class="fas fa-dot-circle text-danger"></i> Terlambat
                                  </li>
                                  <li class="list-inline-item">
                                      <i class="fas fa-dot-circle text-danger"></i> Tidak Hadir
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div id="product-sales" style="height:305px"></div>
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
      Morris.Area({
        element: 'product-sales',
        data: [
          {
            period: '2012',
            presence: 50,
            late: 80,
            absence: 20
          },
          {
            period: '2013',
            presence: 130,
            late: 100,
            absence: 80
          },
          {
            period: '2014',
            presence: 80,
            late: 60,
            absence: 70
          },
          {
            period: '2015',
            presence: 70,
            late: 200,
            absence: 140
          },
          {
            period: '2016',
            presence: 180,
            late: 150,
            absence: 140
          },
          {
            period: '2017',
            presence: 105,
            late: 100,
            absence: 80
          },
          {
            period: '2018',
            presence: 250,
            late: 150,
            absence: 200
          }
        ],
        xkey: 'period',
        ykeys: ['presence', 'late', 'absence'],
        labels: ['Hadir', 'Terlambat', 'Tidak Hadir'],
        pointSize: 2,
        fillOpacity: 0,
        pointStrokeColors: ['#4798e8', '#ccc', '#d9153e'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 2,
        hideHover: 'auto',
        lineColors: ['#4798e8', '#ccc', '#d9153e'],
        resize: true
      });
    });
    </script>

@endsection
