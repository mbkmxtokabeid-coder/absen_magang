@extends('layouts.apps')

@section('IT Teams', "IT Teams - Absensi Peserta Magang CV. Inti Grafika")

@section('extend_style')
<link href="{{ asset('assets/libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb mb-5">
          <div class="row">
            <div class="col-5 align-self-center">
              <h4 class="page-title"><i class="ri-shield-user-line" style="font-size:1.2rem;"></i> Developer Teams</h4>
              <div class="d-flex align-items-center">

              </div>
            </div>
            <div class="col-7 align-self-center">
              <div class="d-flex no-block justify-content-end align-items-center">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Developer Teams</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================== -->
        <!-- Presence Graph -->
        <!-- ============================================================== -->
        <div class="row el-element-overlay d-flex justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('assets/images/teams/teams-richy.jpg') }}" alt="user" />
                            <div class="el-overlay">
                                <ul class="list-style-none el-info">
                                    <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ asset('assets/images/teams/teams-richy.jpg') }}"><i class="sl-icon-magnifier"></i></a></li>
                                    <li class="el-item"><a class="btn default btn-outline el-link" href="https://www.linkedin.com/in/richy-r-b18625105/" target="_blank"><i class="sl-icon-link"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="el-card-content">
                            <h4 class="m-b-0">Richy Rotuahta Saragih</h4> <span class="text-muted">Full-Stack Developer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('assets/images/teams/teams-taufiq.jpg') }}" alt="user" />
                            <div class="el-overlay">
                                <ul class="list-style-none el-info">
                                    <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ asset('assets/images/teams/teams-taufiq.jpg') }}"><i class="sl-icon-magnifier"></i></a></li>
                                    <li class="el-item"><a class="btn default btn-outline el-link" href="https://github.com/taufiq30s" target="_blank"><i class="sl-icon-link"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="el-card-content">
                            <h4 class="m-b-0">M. Taufiq Hidayat Pohan</h4> <span class="text-muted">Back-End Developer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('assets/images/teams/teams-dafa.jpg') }}" alt="user" />
                            <div class="el-overlay">
                                <ul class="list-style-none el-info">
                                    <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ asset('assets/images/teams/teams-dafa.jpg') }}"><i class="sl-icon-magnifier"></i></a></li>
                                    <!-- <li class="el-item"><a class="btn default btn-outline el-link" href="" target="_blank"><i class="sl-icon-link"></i></a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="el-card-content">
                            <h4 class="m-b-0">Dafa Shanrizki</h4> <span class="text-muted">Back-End Developer</span>
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

    <script src="{{ asset('assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('assets/libs/magnific-popup/meg.init.js')}}"></script>

@endsection
