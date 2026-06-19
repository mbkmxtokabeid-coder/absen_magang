@extends('layouts.error_layout')

@section('title', "ERROR 403 - Absensi Peserta Magang Tokabe")

@section('content')
        <div class="error-box bg-light" style="background-image:none;">
            <div class="error-body text-center">
                <h1 class="error-title">403</h1>
                <h3 class="text-uppercase error-subtitle">FORBIDDON ERROR!</h3>
                <p class="text-muted m-t-30 m-b-30">YOU DON'T HAVE PERMISSION TO ACCESS ON THIS SERVER.</p>
                <a href="{{route('login')}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a>
            </div>
        </div>
    </div>

@endsection
