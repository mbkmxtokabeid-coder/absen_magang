@extends('layouts.apps')

@section('title', "Daftar Jurusan - Absensi Peserta Magang Tokabe")

@section('extend_style')
<link href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
@if (session('success'))
    <script>
      swal.fire({
        title: 'Sukses!',
        text: '{{ session("success") }}',
        icon:'success',
        confirmButtonText: 'Ok',
      });
    </script>
@endif
@if (session('error'))
    <script>
      swal.fire({
        title:' Error!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonText: 'Ok'
      })
    </script>
@endif
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
              <h4 class="card-title">Daftar Jurusan</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 d-flex justify-content-end pb-2">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-backdrop='static' onclick="addJur()">
                <i class="ri-play-list-add-line"></i> <span>Tambah Jurusan</span>
            </button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="list_attendence_today" class="table table-striped table-hover table-bordered display">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Jurusan</th>
                  <th class="text-center">Tanggal Pembuatan</th>
                  <th class="text-center">Tanggal Terakhir Update</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jurusans as $jur)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ ucfirst($jur->jurusanNama) }}</td>
                  <td>{{ $jur->created_at }}</td>
                  <td>{{ $jur->updated_at }}</td>
                  <td class="text-center nowrap">

                    <button style="font-size:.95rem" class="btn btn-warning mr-2" data-toggle="modal" data-target="#myModal" data-backdrop='static'  onclick="editJur('{{ $jur->encryptedId }}')"><i class="ti-pencil-alt"></i></button>
                    <form action="{{ route('deleteJurusan',['id'=>$jur->encryptedId]) }}" method="POST" class="d-inline-block">
                      @method('delete')
                      @csrf

                      <button type="button" style="font-size:1rem" class="btn btn-danger ml-2 btn-del" data-toggle="tooltip" data-placement="top" title="Hapus Jurusan" data-id="{{ $jur->jurusanId }}" data-name="{{ $jur->jurusanNama }}">
                        <i class="ti-trash"></i>
                    </button>
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

@if(count($jurusans) > 0)
<script>

  $('.btn-del').on('click', function(e) {
    e.preventDefault();
    let form = $(this).closest('form');
    let nama = $(this).data('name');
    swal({
        title: "Apakah Anda yakin?",
        text: "Jurusan " +nama+ " akan dihapus!",
        type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });


</script>
@endif
<script>
  function addJur() {
    $('#mdlTitle').text('Tambah Jurusan');
    $.ajax({
      type: 'GET',
      url: "{{ route('addJurusan') }}",
      success: function(html){
        $('#mdlContent').html(html);
      }
    });
  }
</script>
<script>
  function editJur(encId) {
    $('#mdlTitle').text('Edit Jurusan');
    $.ajax({
      type: 'GET',
      url: "{{ route('editJurusan') }}",
      data:{
        id: encId,
      },
      success: function(html){
        $('#mdlContent').html(html);
      },
      error: function(xhr) {
            console.log(xhr.responseText); // Cek error jika terjadi
        }
    });
  }
</script>

@endsection
