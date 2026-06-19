@extends('layouts.apps')

@if($mode == "add")
  @section('title', "Tambah Peserta Magang - Absensi Peserta Magang Tokabe")
@else
  @section('title', "Edit Peserta Magang - Absensi Peserta Magang Tokabe")
@endif

@section('extend_style')

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
        <h4 class="page-title">Penilaian</h4>
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
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Row -->
  <div class="row">
    <div class="col-12">
      <div class="card border-success">
          <div class="card-header bg-success">
              <h4 class="m-b-0 text-white">Data Diri</h4>
          </div>
        <div class="card-body">
            <div class="row">
              <div class="col-12 text-right">
                <a href="{{'/users/' . Str::slug(strtolower($user->name), '-') . '/' . $user->id . '/assessment/add'}}" class="btn btn-md btn-outline-info mr-2"><i class="ri-user-star-line"></i> Ubah Nilai</a>
                <a href="#" class="btn btn-md btn-outline-warning"><i class="ri-printer-line"></i> Cetak</a>
              </div>
                <div class="col-lg-3 col-md-3 col-sm-12 text-center">
                    <span class="image-profile image-profile-300 rounded-circle my-4" style="background-image:url({{ url($user->profile_photo_url) }});"></span>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="table-responsive my-4">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <th>{{ucfirst($user->name)}}</th>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <th>{{($assessment == null) ? '-' : $assessment->nim}}</th>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <th>{{ucfirst($user->major)}}</th>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <th>{{($assessment == null) ? '-' : $assessment->class}}</th>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <th>{{$user->semester}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card border-success">
          <div class="card-header bg-success">
              <h4 class="m-b-0 text-white">Kepribadian</h4>
          </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive my-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Komponen Penilaian</th>
                                    <th class="text-center">Bobot</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Integritas (etika, moral, kesungguhan)</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_integrity_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_integrity_value * 4 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Ketepatan waktu dalam bekerja</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_punctuality_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_punctuality_value * 3 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Keahlian berdasarkan bidang ilmu</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_expertise_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_expertise_value * 3 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Kerjasama dalam tim</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_team_work_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_team_work_value * 4 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Komunikasi</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_communication_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_communication_value * 4 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Penggunaan teknologi informasi</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_it_implementation_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_it_implementation_value * 4 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>Pengembangan diri</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_self_development_value }}</td>
                                    <td class="text-center">{{ ($assessment == null) ? '-' : $assessment->q_self_development_value * 3 }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Nilai</th>
                                    @if($assessment == null)
                                        <th class="text-center">-</th>
                                    @else
                                        <th class="text-center">
                                        {{ 
                                            $assessment->q_integrity_value * 4 + $assessment->q_punctuality_value * 3 + $assessment->q_expertise_value * 3 + $assessment->q_integrity_value * 4 + $assessment->q_team_work_value * 4 + $assessment->q_communication_value * 4 + $assessment->q_it_implementation_value * 3 
                                            }}
                                        </th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 text-muted">
                        <p class="mb-1">Kriteria penilaian :</p>
                        <ul>
                            <li>4 = Baik sekali</li>
                            <li>3 = Baik</li>
                            <li>2 = Cukup</li>
                            <li>1 = Kurang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card border-success">
          <div class="card-header bg-success">
              <h4 class="m-b-0 text-white">Teknis lapangan</h4>
          </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive my-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th>Komponen Penilaian</th>
                                    <th>Pengukuran Penilaian</th>
                                    <th class="text-center align-middle">Bobot</th>
                                    <th class="text-center align-middle">Nilai</th>
                                    <th class="text-center align-middle">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle">1</td>
                                    <td>Pemahaman tentang peran mahasiswa di mana ditempatkan</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Paham</li>
                                            <li> = Cukup paham</li>
                                            <li> = Kurang paham</li>
                                            <li> = Tidak paham</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">3</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_role_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_role_value * 3 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">2</td>
                                    <td>Pemahaman terhadap bidang usaha dan proses bisnis dari perusahaan/institusi/komunitas</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Paham</li>
                                            <li> = Cukup paham</li>
                                            <li> = Kurang paham</li>
                                            <li> = Tidak paham</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">3</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_business_fields_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_business_fields_value * 3 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">3</td>
                                    <td>Keberhasilan pencapaian capaian pembelajaran sesuai rencana pembelajaran yang sudah ditentukan</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Tercapai (&gt;75%)</li>
                                            <li> = Cukup tercapai (51% s.d. 75%)</li>
                                            <li> = Kurang tercapai (25% s.d. 50%)</li>
                                            <li> = Tidak tercapai (&lt;25%)</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">5</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_achievement_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_achievement_value * 5 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">4</td>
                                    <td>Keluasan wawasan antar disiplin ilmu</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Ada dan terintegrasi dengan bidang disiplin ilmu mahasiswa</li>
                                            <li> = Ada dan kurang terintegrasi dengan bidang displin ilmu mahasiswa</li>
                                            <li> = Ada, tetapi tidak terintegrasi dengan bidang disiplin ilmu mahasiswa</li>
                                            <li> = Tidak ada</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">4</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_insight_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_insight_value * 4 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">5</td>
                                    <td>Kemampuan merumuskan permasalahan dan rencana pemecahan</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Mampu mendefinisikan masalah dan memiliki minimal 3 alternatif pemecahan dengan menggunakan data dan konteks</li>
                                            <li> = Mampu mendefinisikan masalah dan memiliki minimal 3 alternatif pemecahan</li>
                                            <li> = Mampu mendefinisikan masalah</li>
                                            <li> = Tidak ada rumusan dan rencana pemecahan</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">5</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_solution_to_problem_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_solution_to_problem_value * 5 }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">6</td>
                                    <td>Kemampuan mencapai target pekerjaan</td>
                                    <td>
                                        <ol reversed class="my-0 assessment-criteria">
                                            <li> = Mampu mencapai keseluruhan target pekerjaan (&gt;75%)</li>
                                            <li> = Mampu mencapai sebagian besar target pekerjaan (51% s.d. 75%)</li>
                                            <li> = Mampu mencapai sebagian target pekerjaan (50%)</li>
                                            <li> = Tidak mampu mencapai target pekerjaan (&lt;50%)</li>
                                        </ol>
                                    </td>
                                    <td class="text-center align-middle">5</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_target_value }}</td>
                                    <td class="text-center align-middle">{{ ($assessment == null) ? '-' : $assessment->q_target_value * 5 }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total Nilai</th>
                                    @if($assessment == null)
                                        <th class="text-center">-</th>
                                    @else
                                        <th class="text-center">
                                        {{
                                            $assessment->q_role_value * 3 + 
                                            $assessment->q_business_fields_value * 3 + 
                                            $assessment->q_achievement_value * 5 +
                                            $assessment->q_insight_value * 4 +
                                            $assessment->q_solution_to_problem_value * 5 
                                        }}
                                        </th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

  </div>
  <!-- End Row -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('extend_script')
  <script src="{{ asset('dist/js/passwordGenerator.min.js') }}"></script>
  <script>
    $('#back-to-users').click((e) => {
      e.preventDefault();
      location.href = '/users';
    });
    $('#gen-pass').click((e) => {
      e.preventDefault();
      $('#password').prop('type', 'text');
      $('#password').val(getPassword(12, true));
      $('#password').focus();
    });

    $('#password').keypress((e) => {
      if($('#password').attr('type') == "text"){
        $('#password').prop('type', 'password');
      }
    });
  </script>
@endsection
