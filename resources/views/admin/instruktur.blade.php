@extends('layouts.apps')

@section('title', "Data Instruktur - Absensi Peserta Magang Tokabe")

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
              <h4 class="card-title">instruktur</h4>
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
                  <th class="text-center">Jabatan</th>
                  <th class="text-center">No.HP</th>
                  <th class="text-center">No.Wa</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($instruktur as $instrukturs)
                <tr>
                  <td>{{ ucfirst($instrukturs->user->name) }}</td>
                  <td>{{ $instrukturs->position }}</td>
                  <td>{{ $instrukturs->phone_number }}</td>
                  <td>{{ $instrukturs->whatsapp_number }}</td>
                  <td class="text-center nowrap">
                    <button style="font-size:1rem" class="btn btn-info" onclick='location.href="/instruktur/edit/{{ $instrukturs->user_id }}"' data-toggle="tooltip" data-placement="top" title="Edit Instruktur"><i class="ti-pencil-alt"></i></button>
                    <form action="/instruktur/{{ $instrukturs->user_id }}" method="POST" class="d-inline-block">
                      {{ csrf_field() }}
                      <input type="hidden" name="_method" value="DELETE">
                      <button style="font-size:1rem" class="btn btn-danger ml-2 btn-del" data-toggle="tooltip" data-placement="top" title="Hapus Instruktur"><i class="ti-trash"></i></button>
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
  $('.dt-buttons').append('<button class="btn btn-success btn-add-users ml-auto" onclick="location.href=`/instruktur/add`;"><i class="mdi mdi-account-plus mr-1"></i>Tambah Instruktur</button>');

  // Confirm Delete
  $('.btn-del').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Apakah anda yakin ingin menghapus user ini?",
        text: "Data user yang sudah dihapus tidak bisa dikembalikan lagi!",
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
            url: "/instruktur/{{ isset($instrukturs) ? $instrukturs->user_id : '' }}",
            type: 'DELETE',
            data: {
              userId: "{{ isset($instrukturs) ?$instrukturs->user_id : '' }}",
              "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function(d) {
              if(d.success){
                swal("Sukses", "Data User berhasil dihapus!", "success")
                .then(() => {
                  location.href="/instruktur";
                });
              }
              else{
                swal("Data Instruktur gagal dihapus!", d.msg, "error");
              }
            }
          });
        }
      });
  });
</script>

@endsection
