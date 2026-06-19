@extends('layouts.apps')

@section('title', "Pengaturan Profil - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/prism/prism.css')}}">
<link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css')}}" rel="stylesheet">
<link href="{{ asset('assets/libs/jquery-steps/steps.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.date.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/pickadate/lib/themes/default.time.css')}}">
<link href="{{ asset('assets/libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">

<style media="screen">
  .picker__select--year,
  .picker__select--month {
    padding: 0 .5rem;
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
      <div class="col-12 align-self-center">
        <h4 class="page-title">Pengaturan Akun</h4>
        <div class="d-flex align-items-center">

        </div>
      </div>
      <div class="col-7 align-self-center">
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->

  <!-- ============================================================== -->
  <!-- place order / Exchange -->
  <!-- ============================================================== -->
  <div class="row mt-4">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-muted">Menu</h5>
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Data Diri</a>
            <a class="nav-link" id="v-pills-photo-tab" data-toggle="pill" href="#v-pills-photo" role="tab" aria-controls="v-pills-photo" aria-selected="false">Photo profil</a>
            <a class="nav-link" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">Kata Sandi</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8  col-md-8 col-sm-12">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <div class="row">
            <div class="col-12">
              <div class="card ">
                <div class="card-body mt-1 pb-0 wizard-content">
                  <h5 class="card-title">Ubah Data Profil</h5>
                  <h6 class="card-subtitle">Silahkan isi data diri anda dengan benar.</h6>
                  <hr>
                  <div class="alert alert-danger" id="error-area" style="display:none;">
                    <ul id="error">
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  <hr>
                  </div>
                  <form class="tab-wizard wizard-circle" id="data-diri">
                    <h6 class="card-title">Data Personal</h6>
                    <section class="form-horizontal">
                      <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="name" name="name" value="{{ ucfirst(Auth::user()->name) }}">

                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="birth_place" class="col-sm-3 text-right control-label col-form-label">Tempat Lahir</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Silahkan isi tempat lahir anda" value="{{ isset($profile) ? $profile->birth_place : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="birth_date" class="col-sm-3 text-right control-label col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control pickadate-datelimits" id="birth_date" name="birth_date" placeholder="Silahkan isi tanggal lahir anda" value="{{ isset($profile) ? $profile->birth_date : ''}}">
                        </div>
                      </div>
                    </section>

                    <h6 class="card-title">Kontak</h6>
                    <section>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 text-right control-label col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="email" value="{{ucfirst(Auth::user()->email)}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="telp_number" class="col-sm-3 text-right control-label col-form-label">Nomor Telp</label>
                        <div class="col-sm-9">
                          <input type="text" id="telp_number" name="telp_number" class="form-control telp-number-mask" placeholder="Silahkan isi nomor telepon anda" value="{{ isset($profile) ? $profile->telp_number : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="phone_number" class="col-sm-3 text-right control-label col-form-label">Nomor Handphone</label>
                        <div class="col-sm-9">
                          <input type="text" id="phone_number" name="phone_number" class="form-control phone-number-mask" placeholder="Silahkan isi nomor handphone anda" value="{{ isset($profile) ? $profile->phone_number : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="whatsapp_number" class="col-sm-3 text-right control-label col-form-label">Nomor WhatsApp</label>
                        <div class="col-sm-9">
                          <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control phone-number-mask" placeholder="Silahkan isi nomor whatsapp anda" value="{{ isset($profile) ? $profile->whatsapp_number : ''}}">
                        </div>
                      </div>
                    </section>

                    @if(Auth::user()->role == 1)
                    <h6 class="card-title">Pendidikan</h6>
                    <section>
                      <div class="form-group row">
                        <label for="school_origin" class="col-sm-3 text-right control-label col-form-label">Asal Perguruan Tinggi</label>
                        <div class="col-sm-9">
                        <input type="text" id="school_origin" name="school_origin" class="form-control" value="{{ optional($profile)->school_origin }}" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 text-right control-label col-form-label" for="major">Jurusan</label>
                        <div class="col-sm-9">
                          <select id="major" name="major" class="form-control">
                            <option value="" selected disabled hidden>Silahkan pilih jurusan anda</option>
                            @foreach ($jurusans as $jur)
                              <option value="{{ $jur->jurusanNama }}"
                              {{ isset($profile) && $profile->major == $jur->jurusanNama ? 'selected' : '' }}>{{ $jur->jurusanNama }}
                              </option>
                            @endforeach
                            <!--<option value="Akutansi" {{ isset($profile) && $profile->major == "Akutansi" ? 'selected' : ''}}>Akutansi</option>-->
                            <!--<option value="Manajemen" {{ isset($profile) && $profile->major == "Manajemen" ? 'selected' : ''}}>Manajemen</option>-->
                            <!--<option value="Manajemen Informatika" {{ isset($profile) && $profile->major == "Manajemen Informatika" ? 'selected' : ''}}>Manajemen Informatika</option>-->
                            <!--<option value="Sistem Informasi" {{ isset($profile) && $profile->major == "Sistem Informasi" ? 'selected' : ''}}>Sistem Informasi</option>-->
                            <!--<option value="Teknik Informatika" {{ isset($profile) && $profile->major == "Teknik Informatika" ? 'selected' : ''}}>Teknik Informatika</option>-->
                            <!--<option value="Teknologi Komputer" {{ isset($profile) && $profile->major == "Teknologi Komputer" ? 'selected' : ''}}>Teknologi Komputer</option>-->
                            <!--<option value="Ilmu Komunikasi" {{ isset($profile) && $profile->major == "Ilmu Komunikasi" ? 'selected' : ''}}>Ilmu Komunikasi</option>-->
                            <!--<option value="Teknik Komputer dan Sistem Informasi" {{ isset($profile) && $profile->major == "Teknik Komputer dan Sistem Informasi" ? 'selected' : ''}}>Teknik Komputer dan Sistem Informasi</option>-->
                            <!--<option value="Sistem Komputer dan Teknologi Informasi" {{ isset($profile) && $profile->major == "Sistem Komputer dan Teknologi Informasi" ? 'selected' : ''}}>Sistem Komputer dan Teknologi Informasi</option>-->
                            <!--<option value="Desain Komunikasi Visual" {{ isset($profile) && $profile->major == "Desain Komunikasi Visual" ? 'selected' : ''}}>Desain Komunikasi Visual</option>-->
                            <!--<option value="Teknologi Informasi" {{ isset($profile) && $profile->major == "Teknologi Informasi" ? 'selected' : ''}}>Teknologi Informasi</option>-->
                            <!--<option value="Ilmu Politik" {{ isset($profile) && $profile->major == "Ilmu Politik" ? 'selected' : ''}}>Ilmu Politik</option>-->

                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="semester" class="col-sm-3 text-right control-label col-form-label">Semester</label>
                        <div class="col-sm-9">
                          <input type="number" id="semester" name="semester" class="form-control" min="1" max="12" placeholder="Silahkan masukkan semester anda" value="{{ isset($profile) ? $profile->semester : ''}}">
                        </div>
                      </div>
                    </section>
                    @endif

                    <h6 class="card-title">Domisili</h6>
                    <section>
                      <div class="form-group row">
                        <label for="address" class="col-sm-3 text-right control-label col-form-label" style="line-height:75px;">Alamat Domisili</label>
                        <div class="col-sm-9">
                          <textarea id="address" name="address" class="form-control" rows="3" placeholder="Silahkan isi alamat domisili anda" style="resize:none;">{{ isset($profile) ? $profile->address : ''}}</textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="province" class="col-sm-3 text-right control-label col-form-label">Provinsi</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="province" id="province" value="{{ isset($profile) ? $profile->province : ''}}"></select>
                          {{-- <input type="text" class="form-control" id="province" name="province" placeholder="Provinsi"> --}}
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="region" class="col-sm-3 text-right control-label col-form-label">Kabupaten</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="region" id="region" value="{{ isset($profile) ? $profile->region : ''}}"></select>
                          {{-- <input type="text" class="form-control" id="region" name="region" placeholder="Kabupaten"> --}}
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="sub_district" class="col-sm-3 text-right control-label col-form-label">Kecamatan</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="sub_district" id="sub_district" value="{{ isset($profile) ? $profile->sub_district : ''}}"></select>
                          {{-- <input type="text" class="form-control" id="sub_district" name="sub_district" placeholder="Silahkan isi nomor handphone anda"> --}}
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="postal_code" class="col-sm-3 text-right control-label col-form-label">Kode Pos</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="postal_code" name="postal_code" placeholder="Kode Pos" value="{{ isset($profile) ? $profile->postal_code : ''}}">
                        </div>
                      </div>
                    </section>

                    <h6 class="card-title">Sosial Media</h6>
                    <section>
                      <div class="form-group row">
                        <label for="facebook_url" class="col-sm-3 text-right control-label col-form-label">Facebook</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="Silahkan isi url Facebook anda" value="{{ isset($profile) ? $profile->facebook_url : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="twitter_url" class="col-sm-3 text-right control-label col-form-label">Twitter</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="twitter_url" name="twitter_url" placeholder="Silahkan isi url Twitter anda" value="{{ isset($profile) ? $profile->twitter_url : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="instagram_url" class="col-sm-3 text-right control-label col-form-label">Instagram</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="instagram_url" name="instagram_url" placeholder="Silahkan isi url Instagram anda" value="{{ isset($profile) ? $profile->instagram_url : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="youtube_url" class="col-sm-3 text-right control-label col-form-label">Youtube</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="youtube_url" name="youtube_url" placeholder="Silahkan isi url Youtube anda" value="{{ isset($profile) ? $profile->youtube_url : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="linkedin_url" class="col-sm-3 text-right control-label col-form-label">LinkedIn</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" placeholder="Silahkan isi url LinkedIn anda" value="{{ isset($profile) ? $profile->linkedin_url : ''}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="website_url" class="col-sm-3 text-right control-label col-form-label">Website</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="website_url" name="website_url" placeholder="Silahkan isi url Website anda" value="{{ isset($profile) ? $profile->website_url : ''}}">
                        </div>
                      </div>
                    </section>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade mt-0" id="v-pills-photo" role="tabpanel" aria-labelledby="v-pills-photo-tab">
          <form class="form-horizontal" id="frmUpload" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body mt-1 pb-0 ">
                    <h5 class="card-title">Ubah Photo Profil</h5>
                    <hr>
                    <div class="row">
                      <div class="col-sm-12 col-md-4 col-lg-4 el-element-overlay mx-auto">
                        <div class="card">
                          <div class="el-card-item">
                            <div class="el-card-avatar el-overlay-1">
                              @if (Route::has('login') && Auth::user()->profile_photo_url != null)
                              <a class="image-popup-vertical-fit" href="{{ url(Auth::user()->profile_photo_url) }}">
                                <img src="{{ url(Auth::user()->profile_photo_url) }}" alt="user" id="img-propic" />
                              </a>
                              @else
                              <a class="image-popup-vertical-fit" href="{{ asset('assets/images/users/2.jpg')}}">
                                <img src="{{ asset('assets/images/users/2.jpg')}}" alt="user" id="img-propic" />
                              </a>
                              @endif
                            </div>
                            <div class="el-card-content">
                              <button class="btn btn-sm btn-secondary"><span class="ti-trash"></span></button>
                              <input type="file" name="propic" id="propic" , style="display: none;">
                              <button class="btn btn-sm btn-info mr-2" id="browse"><span class="ti-pencil-alt"></span> Pilih</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="card-body text-right">
                    <button type="submit" class="btn btn-success" id="save-propic"><span class="ti-save mr-2"></span>Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
          <div class="row">
            <div class="col-12">
              <div class="card mt-0">
                <div class="card-body mt-1 pb-0 ">
                  <h5 class="card-title">Ubah Kata Sandi</h5>
                  <hr>
                </div>
                <div class="card-body">
                  <form class="form-horizontal">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Kata sandi lama</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="old-pass">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Kata sandi baru</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" id="new-pass">
                        </div>
                        <div class="col-sm-3">
                          <button type="button" class="form-control btn btn-success waves-effect waves-light" id="gen-pass">Generate</button>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Konfirmasi kata sandi</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="conf-pass">
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="card-body">
                      <div class="form-group m-b-0 text-right">
                        <button type="button" class="btn btn-dark waves-effect waves-light" id="back-to-profile">X</button>
                        <button type="button" class="btn btn-info waves-effect waves-light" id="btnPassSave">Save</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

<script src="{{ asset('assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js')}}"></script>
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js')}}"></script>

<script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{ asset('dist/js/pages/forms/mask/mask.init.js')}}"></script>

<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.date.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/picker.time.js')}}"></script>
<script src="{{ asset('assets/libs/pickadate/lib/compressed/legacy.js')}}"></script>
<script src="{{ asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{ asset('assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('assets/libs/magnific-popup/meg.init.js')}}"></script>

<script src="{{ asset('assets/libs/indonesian-address/address-autoload.js')}}" async></script>
<script src="{{ asset('dist/js/passwordGenerator.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
 $(function() {
    $(".telp-number-mask").inputmask("999-9999-9999");
    $(".phone-number-mask").inputmask("+62 999-9999-99999");

    var dateNow = new Date();
    $('.pickadate-datelimits').pickadate({
        format: 'yyyy-mm-dd', // Format yang dikirimkan ke server
        formatSubmit: 'yyyy-mm-dd', // Pastikan yang dikirim ke input hidden
        hiddenName: true, // Supaya form mengirim value dengan format yang benar
        min: [1900, 1, 1],
        max: [dateNow.getFullYear(), dateNow.getMonth() + 1, dateNow.getDate()], // Pastikan bulan benar
        selectMonths: true,
        selectYears: 100, // Biarkan user memilih tahun lebih lama
        setDefaultDate: false, // Jangan set default hari ini
        today: '',
        close: 'Close',
        clear: ''
    });
});


  // Ganti Password
  $('#btnPassSave').click((e) => {
    e.preventDefault();
    if ($('#new-pass').val() != $('#conf-pass').val()) {
      swal("Kata sandi baru anda tidak sama.", "Pastikan kata sandi baru dan konfirmasi kata sandi sama", "error")
        .then(() => {
          $('#conf-pass').focus();
        });
    } else {
      $.ajax({
        url: "{{ route('user.changepass') }}",
        type: "PUT",
        data: {
          "_token": "{{ csrf_token() }}",
          oldPass: $('#old-pass').val(),
          newPass: $('#new-pass').val(),
          confPass: $('#conf-pass').val(),
        },
        dataType: "json",
        success: (data) => {
          if (data.success) {
            swal("Sukses", "Password berhasil diperbarui!", "success")
              .then(() => {
                location.href = "/user/profile";
              });
          } else {
            swal("Password gagal diperbaharui!", data.msg, "error")
              .then(() => {
                $('#old-pass').val('');
                $('#old-pass').focus();
              });
          }
        },
        error: (data) => {
          swal("Error", data.msg, "error");
        }
      });
    }
  });

  $('#new-pass').keypress((e) => {
    if ($('#new-pass').attr('type') == "text") {
      $('#new-pass').prop('type', 'password');
    }
    // Trigger to save password when press Enter
    triggerSavePass(e.which);
  });

  $('#conf-pass').keypress((e) => {
    triggerSavePass(e.which);
  });

  $('#old-pass').keypress((e) => {
    triggerSavePass(e.which);
  });

  function triggerSavePass(code) {
    console.log("masuk");
    if (code == 13) {
      $('#btnPassSave').click();
    }
  }

  // Generate Password
  $('#gen-pass').click((e) => {
    e.preventDefault();
    $('#new-pass').prop('type', 'text');
    $('#new-pass').val(getPassword(12, true));
    $('#new-pass').focus();
  });

  // Wizard Data diri
  $(".tab-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
      finish: "Save"
    },
    onFinished: function(event, currentIndex) {
      // Get Data from Form Data Diri
      let txtName = $('#name').val();
      let txtEmail = $('#email').val();
      let txtBirthPlace = $('#birth_place').val();
      let txtBirthDate = $('#birth_date').val();
      let txtTelpNumber = $('#telp_number').val();
      let txtPhoneNumber = $('#phone_number').val();
      let txtWaNumber = $('#whatsapp_number').val();
      let txtSchoolOrigin = $('#school_origin').val();
      let txtMajor = $('#major').val();
      let txtSemester = $('#semester').val();
      let txtAddress = $('#address').val();
      let txtProvince = $('#province').val();
      let txtRegion = $('#region').val();
      let txtSubDistrict = $('#sub_district').val();
      let txtPostalCode = $('#postal_code').val();
      let txtFbUrl = $('#facebook_url').val();
      let txtTwUrl = $('#twitter_url').val();
      let txtIgUrl = $('#instagram_url').val();
      let txtytUrl = $('#youtube_url').val();
      let txtLinkendUrl = $('#linkedin_url').val();
      let txtWebUrl = $('#website_url').val();

      $.ajax({
        url: "{{ $mode == 0 ? route('profile.save') : route('profile.update') }}",
        type: "{{ $mode == 0 ? 'POST' : 'PUT' }}",
        data: {
          "_token": "{{ csrf_token() }}",
          name: txtName,
          email: txtEmail,
          birth_place: txtBirthPlace,
          birth_date: txtBirthDate,
          telp_num: txtTelpNumber,
          phone_num: txtPhoneNumber,
          wa_num: txtWaNumber,
          major: txtMajor,
          semester: txtSemester,
          address: txtAddress,
          province: txtProvince,
          region: txtRegion,
          sub_district: txtSubDistrict,
          postal: txtPostalCode,
          fb: txtFbUrl,
          tw: txtTwUrl,
          ig: txtIgUrl,
          yt: txtytUrl,
          in: txtLinkendUrl,
          web: txtWebUrl
        },
        dataType: 'json',
        success: (data) => {
          if (data) {
            swal("Sukses", "Profl User berhasil diperbarui!", "success")
              .then(() => {
                location.href = "/user/profile";
              });
          } else {
            swal("Update data profil gagal!", data.msg, "error");
          }
        },
        error: function(err) {
          console.log("Meninggoy");
          console.warn(err.responseJSON.errors);
          $('#error-area').css('display', 'block');
          if(err.status == 422)
          $.each(err.responseJSON.errors, function(key, item) {
            $("#error").append("<li>" + key + ": " + item[0] + "</li>")
            console.log(key);
          });

        }
      });
    }
  });

  // Browse Image
  $('#browse').click((e) => {
    e.preventDefault();
    $('#propic').click();
  });

  // Show Selected Image to
  $('#propic').change(function() {
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img-propic').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#img-propic').attr('src', '../../assets/images/users/{{Auth::id()}}.jpg');
    }
  });

  // Upload Profile Picture
  $('#frmUpload').submit((e) => {
    e.preventDefault();
    if ($('#propic').val() == "") {
      swal('Error', 'Silahkan pilih gambar foto profil yang ingin anda gunakan', 'error');
    } else {
      let formData = new FormData(document.getElementById('frmUpload'));
      $.ajax({
        url: "{{ route('profile.upload') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: ()=> {
          $('#propic').text("Waiting");
          $('#propic').prop('disabled', true);
        },  
        success: (data) => {
          $('#propic').html('<span class="ti-save mr-2"></span>Simpan');
          $('#propic').prop('disabled', false);
          if (data.success) {
            swal("Sukses", "Foto Profil berhasil diperbarui!", "success")
              .then(() => {
                location.href = "/user/profile";
              });
          } else {
            swal("Error", data.msg, "error");
          }
        }
      });
    }
  });

  $('#back-to-profile').click((e) => {
    location.href = '/user/profile';
  });
</script>
@endsection