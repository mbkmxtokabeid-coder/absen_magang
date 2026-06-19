@extends('layouts.apps')

@section('title', 'Absensi - Absensi Peserta Magang Tokabe')

@section('extend_style')
<link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/extra-libs/calendar/calendar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/jbox/dist/jBox.all.min.css') }}" rel="stylesheet">
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
        <h4 class="page-title">Kehadiran</h4>
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
              <li class="breadcrumb-item active" aria-current="page">Kehadiran</li>
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
                @if ($notif != false)
                @if ($notif['display'] == true && $notif['text'] == 'Masuk' && $profileStatus == true)
                <div class="col-sm-12 col-md-8 col-lg-8 text-center ml-auto alert alert-success" role="alert">
                  Anda sudah melakukan absensi masuk, waktu pulang belum saatnya!
                </div>
                @elseif ($notif['display'] == true && $notif['text'] == "Keluar" &&
                $profileStatus == true)
                <div class="col-sm-12 col-md-8 col-lg-8 text-center ml-auto alert alert-success" role="alert">
                  Anda sudah melakukan absensi hari ini!
                </div>
                @elseif($notif['display'] == false && $profileStatus == true)
                <form action="{{ route('user.attendence.store') }}" method="post">
                  @csrf
                  <div class="row">
                    @if ($attendenceLateType == 'Terlambat')
                    <div class="col-12  text-left">
                      <label for="late_reason">Alasan terlambat :</label>
                      <input type="{{ $attendenceLateType == 'Terlambat' ? 'text' : 'hidden' }}" class="form-control mb-2" name="late_reason" id="late_reason" value="{{ $attendenceLateType == 'Terlambat' ? '' : '-' }}" required>
                    </div>
                    @endif
                    <div class="col-12 text-right">
                      <button type="submit" class="btn btn-lg btn-success" name="button">{{ $notif['text'] }}</button>
                    </div>
                  </div>
                </form>
                @elseif($profileStatus == false)
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
  <!-- place order / Exchange -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div id="calendar"></div>
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
<script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>

<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"></script>
{{-- <script src="{{ asset('dist/js/pages/calendar/cal-init.js')}}"></script> --}}
<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweet-alert.init.js') }}"></script>
<script src="{{ asset('assets/libs/jbox/dist/jBox.all.min.js') }}"></script>

<script type="text/javascript">
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
    var attendenceData = "{{ json_encode($attendenceData, JSON_NUMERIC_CHECK) }}";
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
          dayElement.append("<div class='attendence-icon-box attendence-active-" + displayData.type +
            " h-100 w-100 d-flex align-items-center justify-content-center' title='Masuk pukul " +
            attendLoginTime + "'></div>")
        } else {
          dayElement.append("<div class='attendence-icon-box attendence-active-" + displayData.type +
            " h-100 w-100 d-flex align-items-center justify-content-center' title='Masuk pukul " +
            attendLoginTime + " Pulang pukul " + attendLogoutTime + "'></div>")
        }
        $(".fc-day-top[data-date='" + attendDate + "']").addClass('text-light');
        // $(".fc-day-top[data-date='"+attendDate+"']").append('<div class="ml-2 font-weight-bold mt-2 w-100">15:00</div>')
      }
      $('.attendence-active-attend').append(
        "<i class='ri-check-double-line text-light attendence-icon'></i>");
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
</script>

@endsection