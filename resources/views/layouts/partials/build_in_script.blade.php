<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- apps -->
<script src="{{ asset('dist/js/app.min.js')}}"></script>

@if(Auth::user() != null && (Auth::user()->role == 0 || Auth::user()->role == 2))
    @include('layouts/partials/admin_theme_script')
@elseif (Auth::user() != null && Auth::user()->role == 1)
    @include('layouts/partials/user_theme_script')
@else
    @include('layouts/partials/user_theme_script')
@endif

<script src="{{ asset('dist/js/app-style-switcher.horizontal.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
{{-- Moment js --}}
<script src="{{ asset('assets/libs/moment/min/moment-with-locales.min.js')}}"></script>

<!--Wave Effects -->
<script src="{{ asset('dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{ asset('dist/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('dist/js/custom.min.js')}}"></script>

<script type="text/javascript">
    setInterval(function() {
        $('#liveClock').text(moment().format('HH:mm:ss'));
    }, 1000)
</script>
