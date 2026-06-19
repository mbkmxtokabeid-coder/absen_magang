@extends('layouts.apps')

@section('title', "Profil $profile->name - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/extra-libs/calendar/calendar.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/libs/jbox/dist/jBox.all.min.css')}}" rel="stylesheet">
<style media="screen">
  .nav-tabs .nav-item {
    margin-bottom: -3px !important;
  }
</style>
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
        <h4 class="page-title">Profile</h4>
        <div class="d-flex align-items-center">

        </div>
      </div>
      <div class="col-7 align-self-center">
        <div class="d-flex no-block justify-content-end align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">User</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
  <!-- Start Page Content -->
  <!-- ============================================================== -->
  <!-- Row -->
  <div class="row mt-3">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card">
        <div class="card-body">
          <center class="m-t-30">
            <span class="image-profile image-profile-150 rounded-circle" style="background-image:url({{ url($profile->profile_photo_url) }});"></span>
            <h4 class="card-title m-t-10">{{ ucfirst($profile->name) }}</h4>
            <h6 class="card-subtitle">{{ $profile->job_role }}</h6>
          </center>
        </div>
        <div>
          <hr>
        </div>
        <div class="card-body">
          <small class="text-muted">Email address </small>
          <h6 class="mb-4">{{ $profile->email }}</h6>
          @if ($profile->role != 0)
          <small class="text-muted p-t-30 db">Tempat dan Tanggal Lahir</small>

          @if($profile->birth_date != '-' )
          <h6 class="mb-4">{{ isset($profile) ? $profile->birth_place . ", " : '-'}}
            <span id="birth-date"></span>
          </h6>
          @else
          <h6 class="mb-4">-</h6>
          @endif

          @endif



          {{-- <small class="text-muted p-t-30 db">Maps Alamat Domisili</small>

                        <div class="map-box mb-2">

                            @if(isset($profile))
                                <iframe src="https://www.google.com/maps/place/{{ Str::slug($profile->address . ' ' . $profile->sub_district, '+') }}" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
          @endif
        </div> --}}

        <small class="text-muted p-t-30 db">Social Profile</small>
        <div class="d-flex justify-content-start mb-4">
          @if(isset($profile))
          @if($profile->facebook_url != '-')
          <a href="{{$profile->facebook_url}}" class="btn btn-circle btn-primary sosmed-icon"><i class="ri-facebook-fill text-light"></i></a>
          @endif
          @endif

          @if(isset($profile))
          @if($profile->twitter_url != '-')
          <a href="{{$profile->twitter_url}}" class="btn btn-circle btn-info sosmed-icon"><i class="ri-twitter-fill text-light"></i></a>
          @endif
          @endif

          @if(isset($profile))
          @if($profile->instagram_url != '-')
          <a href="{{$profile->instagram_url}}" class="btn btn-circle btn-danger sosmed-icon"><i class="ri-instagram-line text-light"></i></a>
          @endif
          @endif

          @if(isset($profile))
          @if($profile->youtube_url != '-')
          <a href="{{$profile->youtube_url}}" class="btn btn-circle btn-danger sosmed-icon"><i class="ri-youtube-line text-light"></i></a>
          @endif
          @endif

          @if(isset($profile))
          @if($profile->linkedin_url != '-')
          <a href="{{$profile->linkedin_url}}" class="btn btn-circle btn-dark sosmed-icon"><i class="ri-linkedin-fill text-light"></i></a>
          @endif
          @endif

          @if(isset($profile))
          @if($profile->website_url != '-')
          <a href="{{$profile->website_url}}" class="btn btn-circle btn-secondary sosmed-icon"><i class="ri-global-line text-light"></i></a>
          @endif
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="col-lg-8 col-xlg-9 col-md-7">
    <div class="card">
      <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
          @if($profile->role == 1)
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#timeline" role="tab"><span class="hidden-sm-up"><i class="ri-time-line"></i></span> <span class="hidden-xs-down">Timeline</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#attendence" role="tab"><span class="hidden-sm-up"><i class="ri-time-line"></i></span> <span class="hidden-xs-down">Kehadiran</span></a> </li>
          @endif
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
          <div class="tab-pane p-20 show active" id="profile" role="tabpanel">
            <div class="">
              @if ($profile->role != 0)

              <h5 class="mb-4">Informasi pendidikan</h5>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Asal Perguruan Tinggi
                </div>
                <div class="col-md-7 col-sm-12">
                  <b>{{ $profile->school_origin }}</b>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Jurusan
                </div>
                <div class="col-md-7 col-sm-12">
                  <b>{{ $profile->major}}</b>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Semester
                </div>
                <div class="col-md-7 col-sm-12">
                  <b>{{ $profile->semester }}</b>
                </div>
              </div>
              <hr>
              @endif

              <h5 class="mt-5 mb-4">Kontak</h5>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Nomor Handphone
                </div>
                <div class="col-md-7 col-sm-12">
                  <b><a href="tel:{{ $profile->phone_number != '-' ? $profile->phone_number : '' }}" class="text-success">{{ $profile->phone_number != '-' ? $profile->phone_number : '' }}</a></b>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Nomor Telp
                </div>
                <div class="col-md-7 col-sm-12">
                  <b><a href="tel:{{ $profile->telp_number != '-' ? $profile->telp_number : ''}}" class="text-success">{{ $profile->telp_number != '-' ? $profile->telp_number : ''}}</a></b>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  Nomor WhatsApp
                </div>
                <div class="col-md-7 col-sm-12">
                  <b><a href="tel:{{ $profile->whatsapp_number != '-' ? $profile->whatsapp_number : ''}}" class="text-success">{{ $profile->whatsapp_number != '-' ? $profile->whatsapp_number : '' }}</a></b>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-5 col-sm-12">
                  <span style="line-height:64px;">
                    Alamat Domisili
                  </span>
                </div>
                <div class="col-md-7 col-sm-12">
                  <b>
                    <div>{{ $profile->address != '-' ? $profile->address : ''}}</div>
                    <div>{{ $profile->sub_district != '-' ? "Kec. " . $profile->sub_district : ''}} {{ $profile->region != '-' ? "Kab. " . $profile->region : ''}}</div>
                    <div>{{ $profile->province != '-' ? $profile->province : ''}}{{ $profile->postal_code != '-' ? ". " . $profile->postal_code : ''}}</div>
                  </b>
                </div>
              </div>
              <hr>
              @if(Auth::user()->id == $profile->id && Auth::user()->role != 2)
              <div class="row">
                <div class="col-12 text-right my-3">
                  <a href="{{ route('profile.setting') }}" class="btn btn-lg btn-success"><i class="ri-edit-box-line"></i> Edit Profile</a>
                </div>
              </div>
              @else
              <div class="row">
                <div class="col-12 text-right my-3">
                  <a href="{{ (Auth::user()->role != 2) ? route('admin.users') : route('supervisor.users') }}" class="btn btn-lg btn-info"><i class="ri-arrow-go-back-line"></i> Kembali</a>
                </div>
              </div>
              @endif
            </div>
          </div>
          <div class="tab-pane p-20" id="timeline" role="tabpanel">
            <div class="row d-flex justify-content-end">
              <ul class="nav nav-pills m-b-30">
                <li class="nav-item"> <a href="#" class="nav-link disabled">Mode </a> </li>
                <li class="nav-item"> <a href="#logbook-timeline" class="nav-link active" data-toggle="tab" aria-expanded="false"><i class="ri-stack-line" style="font-size:1rem;"></i></a> </li>
                <li class="nav-item"> <a href="#logbook-table" class="nav-link" data-toggle="tab" aria-expanded="false"><i class="ri-table-2" style="font-size:1rem;"></i></a> </li>
              </ul>
            </div>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane active" id="logbook-timeline" role="tabpanel">
                @if(count($timelines) > 0)
                <ul class="timeline">
                  @foreach (collect($timelines)->sortByDesc('date')->all() as $timeline)
                  <li class="{{ $loop->index % 2 != 0 ? "timeline-inverted " : ' ' }} timeline-item">
                    <div class="timeline-badge" style="background:{{$timeline->color}}!important">
                      <span class="font-12">
                        {{date_format(date_create($timeline->date), "d M")}}
                      </span>
                    </div>
                    <div class="timeline-panel">
                      <div class="timeline-heading">
                        <h4 class="timeline-title" style="color:{{$timeline->color}}!important">{{$timeline->job_status}}</h4>
                        <p class="text-muted"><i class="mdi mdi-clock-alert"></i> {{date_format(date_create($timeline->date), "l, j F Y")}} </p>
                        <hr>
                      </div>
                      <div class="timeline-body">
                        <h6>Aktivitas</h6>
                        {!! $timeline->activity !!}

                        <hr class="mt-4">
                        <h6>Masalah</h6>
                        {!! $timeline->obstacles !!}
                      </div>
                      <hr>
                      @if(($timeline->image_path != NULL) && $timeline->image_path != '-')
                      <button class="btn btn-info waves-effect waves-light view-images" data-id="{{ $timeline->id }}">Lihat Gambar</button>
                      @endif
                    </div>
                  </li>
                  @endforeach
                </ul>
                @else
                <div class="row d-flex justify-content-start">
                  <div class="alert alert-danger col-sm-12 col-md-6 col-lg-6">
                    Logbook kamu masih kosong.
                    @if(Auth::user()->role == 1)
                    <a href="{{route('user.logbook')}}" class="btn btn-info">Isi Logbook</a>
                    @endif
                  </div>
                </div>
                @endif
              </div>
              <div class="tab-pane p-20" id="logbook-table" role="tabpanel">
                <div class="table-responsive">
                  <table id="list-logbook-table" class="table table-striped table-hover table-bordered display">
                    <thead>
                      <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aktivitas</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Masalah</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach(collect($timelines)->sortByDesc('date')->all() as $timeline)
                      <tr>
                        <td data-sort="{{ date('m/d/y', strtotime($timeline->date)) }}" class="align-middle">{{ date('l, d F Y', strtotime($timeline->date)) }}</td>
                        <td class="align-middle">{{ $timeline->job_status }}</td>
                        <td>{!! $timeline->activity !!}</td>
                        <td class="align-middle">{{ $timeline->duration }}</td>
                        <td>{!! $timeline->obstacles !!}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Modal markup: https://getbootstrap.com/docs/4.4/components/modal/ -->
            <div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Foto Kegiatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <!-- Carousel markup goes here -->
                    <div id="carouselExample" class="carousel slide" data-ride="carousel">
                      <div class="carousel-inner">

                      </div>
                      <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane p-20" id="attendence" role="tabpanel">
            <div class="row d-flex justify-content-end">
              <ul class="nav nav-pills m-b-30">
                <li class="nav-item"> <a href="#" class="nav-link disabled">Mode </a> </li>
                <li class="nav-item"> <a href="#attendence-calendar" class="nav-link active" data-toggle="tab" aria-expanded="false"><i class="ri-stack-line" style="font-size:1rem;"></i></a> </li>
                <li class="nav-item"> <a href="#attendence-table" class="nav-link" data-toggle="tab" aria-expanded="false"><i class="ri-table-2" style="font-size:1rem;"></i></a> </li>
              </ul>
            </div>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane active" id="attendence-calendar" role="tabpanel">
                <div id="calendar"></div>
              </div>
              <div class="tab-pane" id="attendence-table" role="tabpanel">
                <div class="table-responsive">
                  <table id="list-attendence-table" class="table table-striped table-bordered display">
                    <thead>
                      <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Masuk</th>
                        <th class="text-center">Keluar</th>
                        <th class="text-center">Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach (collect($attendenceData)->sortByDesc('created_at')->all() as $attendence)
                      <tr>
                        <td>{{$attendence->login_status}}</td>
                        <td>{{date_format(date_create($attendence->created_at), "H:i:s")}}</td>
                        <td>{{date_format(date_create($attendence->updated_at), "H:i:s")}}</td>
                        <td data-sort="{{ date('m/d/y', strtotime($attendence->created_at)) }}">{{date_format(date_create($attendence->created_at), "l, j M Y")}}</td>
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
    </div>
  </div>
  <!-- Column -->
</div>
<!-- Row -->
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
<!--c3 JavaScript -->
<script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js')}}"></script>

<script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script src="{{ asset('assets/libs/moment/min/moment-with-locales.min.js')}}"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/libs/jbox/dist/jBox.all.min.js')}}"></script>

<script type="text/javascript">
  @if(isset($profile) ? $profile -> birth_date : '' != '')
  moment.locale('id');
  var moments = moment("{{ isset($profile) ? $profile->birth_date : ''}}");
  $('#birth-date').text(moments.locale('id').format('LL'))
  @endif

    ! function($) {
      "use strict";
      var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
          this.$event = ('#calendar-events div.calendar-events'),
          this.$categoryForm = $('#add-new-event form'),
          this.$extEvents = $('#calendar-events'),
          this.$modal = $('#my-event'),
          this.$saveCategoryBtn = $('.save-category'),
          this.$calendarObj = null
      };
      /* on select */
      CalendarApp.prototype.onSelect = function(start, end, allDay) {
          var $this = this;
          $this.$modal.modal({
            backdrop: 'static'
          });
          $this.$calendarObj.fullCalendar('unselect');
        },
        /* Initializing */
        CalendarApp.prototype.init = function() {
          /*  Initialize the calendar  */
          var date = new Date();
          var d = date.getDate();
          var m = date.getMonth();
          var y = date.getFullYear();
          var form = '';
          var today = new Date($.now());
          var defaultEvents = [];
          var $this = this;
          $this.$calendarObj = $this.$calendar.fullCalendar({
            // slotDuration: '00:15:00',
            /* If we want to split day time each 15minutes */
            defaultView: 'month',
            handleWindowResize: true,
            header: {
              left: 'prev,next today',
              center: 'title',
              right: ''
            },
            events: defaultEvents,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            eventLimit: false, // allow "more" link when too many events
            selectable: true,
            // drop: function(date) { $this.onDrop($(this), date); },
            select: function(start, end, allDay) {
              $this.onSelect(start, end, allDay);
            },
            // eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }
          });
        },
        //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    }(window.jQuery),
    //initializing CalendarApp
    $(window).on('load', function() {
      $.CalendarApp.init();
      // Convert data to JSON
      var attendenceData = "{{json_encode($attendenceData, JSON_NUMERIC_CHECK)}}";
      attendenceData = JSON.parse(attendenceData.replace(/&quot;/g, '"'));

      function getDateString(dateData) {
        var date = ""
        date += dateData.getFullYear() + '-';
        if (dateData.getMonth() >= 9) {
          date += (dateData.getMonth() + 1).toString() + '-';
        } else if (dateData.getMonth() < 9) {
          date += "0" + (dateData.getMonth() + 1).toString() + '-';
        }
        if (dateData.getDate() >= 10) {
          date += dateData.getDate().toString();
        } else if (dateData.getDate() < 10) {
          date += "0" + dateData.getDate().toString();
        }
        return date;
      }

      function getTimeString(dateData) {
        // Absensi pada 15.20.13
        var time = "";
        // Hours
        if (dateData.getHours() >= 9) {
          time += dateData.getHours().toString() + '.';
        } else if (dateData.getHours() < 9) {
          time += "0" + dateData.getHours().toString() + '.';
        }
        // Minutes
        if (dateData.getMinutes() >= 9) {
          time += dateData.getMinutes().toString();
        } else if (dateData.getMinutes() < 9) {
          time += "0" + dateData.getMinutes().toString();
        }
        return time;
      }

      function writeAttendenceData() {
        for (var i = 0; i < attendenceData.length; i++) {
          var attendData = attendenceData[i];
          var attendDate = getDateString(new Date(attendData.created_at));
          var dayElement = $('.fc-day[data-date="' + attendDate + '"]')
          var displayData = [];
          var attendLoginTime = getTimeString(new Date(attendData.created_at));
          var attendLogoutTime = getTimeString(new Date(attendData.updated_at));

          if (attendData.login_status == "Tepat Waktu") {
            displayData = {
              'background': 'bg-success',
              'type': 'attend',
              'text': 'Tepat Waktu'
            };
          } else if (attendData.login_status == "Terlambat") {
            displayData = {
              'background': 'bg-info',
              'type': 'late',
              'text': 'Terlambat'
            };
          }
          dayElement.addClass(displayData.background + ' h-100 text-center ');
          if (attendLoginTime == attendLogoutTime) {
            dayElement.append("<div class='attendence-icon-box attendence-active-" + displayData.type + " h-100 w-100 d-flex align-items-center justify-content-center' title='Masuk pukul " + attendLoginTime + "'></div>")
          } else {
            dayElement.append("<div class='attendence-icon-box attendence-active-" + displayData.type + " h-100 w-100 d-flex align-items-center justify-content-center' title='Masuk pukul " + attendLoginTime + " Pulang pukul " + attendLogoutTime + "'></div>")
          }
          $(".fc-day-top[data-date='" + attendDate + "']").addClass('text-light');
          // $(".fc-day-top[data-date='"+attendDate+"']").append('<div class="ml-2 font-weight-bold mt-2 w-100">15:00</div>')
        }
        $('.attendence-active-attend').append("<i class='ri-check-double-line text-light attendence-icon'></i>");
        $('.attendence-active-late').append("<i class='ri-check-line text-light attendence-icon'></i>");
        new jBox('Tooltip', {
          attach: '.attendence-icon-box'
        });
      }
      writeAttendenceData()
      $('.fc-next-button').on('click', function() {
        writeAttendenceData();
      })
      $('.fc-prev-button').on('click', function() {
        writeAttendenceData();
      })
      $('.fc-today-button').on('click', function() {
        writeAttendenceData();
      })
    })

  $('#list-logbook-table').DataTable({
    "order": [0, "desc"],
    "columnDefs": [{
      "targets": 0,
      "type": "date-eu"
    }],
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });

  $('#list-attendence-table').DataTable({
    "order": [3, "desc"],
    "columnDefs": [{
      "targets": 0,
      "type": "date-eu"
    }],
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });

  // Preview Image Attactments
  $('.view-images').on('click', function(e) {
    var logid = $(this).data('id');
    $.ajax({
      url: "{{ (Auth::user()->role == 2) ? route('supervisor.logphotoes') : route('profile.logphotoes') }}",
      type: "post",
      data: {
        "_token": "{{ csrf_token() }}",
        "id": logid,
      },
      dataType: "json",
      success: (data) => {
        $('.carousel-inner').html(data.response);
        $('#imagePreview').modal('show');
      }
    });
  });

  $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
  $('.dt-buttons').addClass('w-100 d-flex my-3');
</script>

@endsection
