@extends('layouts.apps')

@section('title', "Kampus - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
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
              <h3 class="m-b-0">Hello, {{ucfirst(Auth::user()->name)}}</h3>
              <span>{{date("l, d F Y")}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================== -->
  <!-- Table user attendence -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h4 class="card-title">Data Kampus</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              {{-- Filter berdasarkan :
                                 --}}
            </div>
          </div>
          <div class="table-responsive">
            <table id="list_attendence_today" class="table table-striped table-hover table-bordered display">
              <thead>
                <tr>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Telepon</th>
                  <th class="text-center">Alamat</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($allCampus as $campus)
                <tr>
                  <td>{{ $campus->name }}</td>
                  <td>{{ $campus->email }}</td>
                  <td>{{ $campus->telp }}</td>
                  <td>{{ $campus->address }}</td>
                  <td class="text-center nowrap">
                    <button style="font-size:1rem" class="btn btn-info" onclick='location.href="/campus/edit/{{ $campus->id }}"' data-toggle="tooltip" data-placement="top" title="Edit Data Kampus"><i class="ti-pencil-alt"></i></button>
                    <form action="/campus/{{ $campus->id }}" method="POST" class="d-inline-block">
                      {{ csrf_field() }}
                      <input type="hidden" name="_method" value="DELETE">
                      <button style="font-size:1rem" class="btn btn-danger ml-2 campus-btn-del"><i class="ti-trash" data-toggle="tooltip" data-placement="top" title="Hapus Data Kampus" data-id="{{ $campus->id }}"></i></button>
                    </form>
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
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js')}}"></script> --}}
<script type="text/javascript">
  //=============================================//
  //    File export                              //
  //=============================================//
  // dt-buttons
  $('#list_attendence_today').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel', 'pdf'
    ]
  });
  $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

  $('.dt-buttons').addClass('w-100 d-flex my-3');
  $('.dt-buttons').append('<button class="btn btn-success btn-add-users ml-auto" onclick="location.href=`/campus/add`;"><i class="mdi mdi-account-plus mr-1"></i>Tambah Kampus</button>');

  // Confirm Delete
  $('.campus-btn-del').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    swal({
        title: "Apakah anda yakin ingin menghapus data kampus ini?",
        text: "Data kampus yang sudah dihapus tidak bisa dikembalikan lagi!",
        type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/campus/" + id,
            type: 'DELETE',
            data: {
              id: id,
              "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function() {
              swal("Sukses", "Data Kampus berhasil dihapus!", "success")
              .then(() => {
                location.href="/campus";
              });
            }
          });
        }
      });
  });
</script>

@endsection
