@extends('layouts.apps')

@section('title', "Peserta Magang - Absensi Peserta Magang Tokabe")

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
              <h4 class="card-title">Peserta magang</h4>
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
                  <th class="text-center">Asal Kampus</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Bidang</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ ucfirst($user->name) }}</td>
                  <td>{{ ucfirst($user->school_origin) }}</td>
                  <td class="text-center">
                    @if($user->active_status == "active")
                      <span class="label label-success" style="font-size:.9rem;">{{ucfirst($user->active_status)}}</span>
                    @elseif($user->active_status == "nonactive")
                      <span class="label label-danger" style="font-size:.9rem;">{{ucfirst($user->active_status)}}</span>
                    @elseif($user->active_status == "finish")
                      <span class="label label-info" style="font-size:.9rem;">{{ucfirst($user->active_status)}}</span>
                    @endif
                  </td>
                  <td>{{ $user->job_role }}</td>
                  <td class="text-center nowrap">
                    <a href="{{url('/users/' . Str::slug(strtolower($user->name), '-') . '/' . $user->id . '/assessment')}}" class="btn btn-success mr-2" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Penilaian"><i class="ri-star-half-line"></i></a>
                    <a href="{{url('/users/' . Str::slug(strtolower($user->name), '-') . '/' . $user->id)}}" class="btn btn-info mr-2" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Lihat Profile dan Logbook User"><i class="ri-contacts-book-line"></i></a>
                    <button style="font-size:1rem" class="btn btn-warning mr-2" onclick='location.href="/users/edit/{{ $user->id }}"' data-toggle="tooltip" data-placement="top" title="Edit User"><i class="ti-pencil-alt"></i></button>
                    <button type="button" class="btn btn-dark" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Ganti Status" onclick="changeStatusShow({{$user->id}},'{{ucfirst($user->name)}}', '{{strtolower($user->active_status)}}')"><i class="ri-swap-line"></i></button>
                    <!-- <button type="button" class="btn btn-sert" style="font-size:.95rem" data-toggle="tooltip" data-placement="top" title="Sertifikat" onclick="uploadSertifikat({{$user->id}},'{{ucfirst($user->name)}}', '{{strtolower($user->active_status)}}')"><i class="ri-swap-line"></i></button> -->
                    <form action="/user/{{ $user->id }}" method="POST" class="d-inline-block">
                      {{ csrf_field() }}
                      <input type="hidden" name="_method" value="DELETE">
                      <button style="font-size:1rem" class="btn btn-danger ml-2 btn-del" data-toggle="tooltip" data-placement="top" title="Hapus User" data-id="{{ $user->id }}"><i class="ti-trash"></i></button>
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
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><i class="ri-swap-line"></i> Ubah Status Peserta Magang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>Merubah status dari <span id="nameChangeStatus"></span></h4>

          <form class="" action="" method="post" id="changeStatusForm">
            <input type="hidden" name="currentIdUserChangeStatus" id="currentIdUserChangeStatus">
            <table class="table-responsive mt-3">
              <tr>
                <td class="py-2">Status saat ini</td>
                <td class="py-2"><span id="currentStatusChangeStatus" class="ml-3"></span></td>
              </tr>
              <tr>
                <td class="py-2">Ubah menjadi</td>
                <td class="py-2">
                  <select class="form-control ml-3" name="newStatusChangeStatus" id="newStatusChangeStatus">
                    <option value="active">Active</option>
                    <option value="finish">Finish</option>
                    <option value="nonactive">Non-Active</option>
                  </select>
                </td>
              </tr>
            </table>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btnSaveChangeStatus">Save changes</button>
        </div>
      </div>
    </div>
  
  </div>
  <!-- <div class="modal fade" id="uploadSertifikatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><i class="ri-swap-line"></i> Upload Sertifikat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="upload-image-form" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" method="post" id="fileGambarSertifikat">
            <span class="text-danger" id="image-input-error"></span>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save changes</button>
        </div>
      </div>
    </div>
  </div> -->
    
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
</script>
// Confirm Delete
@if(count($users) > 0)
<script>
  $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });

  // }
  function changeStatusShow(id, name, status) {
    $('#nameChangeStatus').text(name);
    $('#currentIdUserChangeStatus').val(id);

    if(status == 'active'){
      $('#currentStatusChangeStatus').empty();
      $('#currentStatusChangeStatus').html('<i class="ri-checkbox-blank-circle-fill text-success"></i> Active')
    }
    else if(status == 'finish'){
      $('#currentStatusChangeStatus').empty();
      $('#currentStatusChangeStatus').html('<i class="ri-checkbox-blank-circle-fill text-info"></i> Finish')
    }
    else if(status == 'nonactive'){
      $('#currentStatusChangeStatus').empty();
      $('#currentStatusChangeStatus').html('<i class="ri-checkbox-blank-circle-fill text-danger"></i> Non-Active')
    }

    $('#changeStatusModal').modal('show');
  }

  // function uploadSertifikat(id, name, status) {
  //   $('#uploadSertifikatModal').modal('show');
  // }

  // $('#upload-image-form').submit(function(e) {
  //   // var gambarSertifikat = $('input[name=fileGambarSertifikat]').val();
  //   e.preventDefault();
  //   let sertif = new FormData(this);
  //   $('#image-input-error').text('');

  //   $.ajax({
  //     type:'POST',
  //     url: `/upload-images`,
  //       data: sertif,
  //       contentType: false,
  //       processData: false,
  //       success: (response) => {
  //         if (response) {
  //           this.reset();
  //           alert('Image has been uploaded successfully');
  //         }
  //       },
  //       error: function(response){
  //         console.log(response);
  //           $('#image-input-error').text(response.responseJSON.errors.file);
  //       }
  //   });
  // })
  $('#btnSaveChangeStatus').click(function() {
    var userIdCurrent = $('input[name=currentIdUserChangeStatus]').val();
    var newStatus = $('select[name=newStatusChangeStatus]').val();

    console.log(userIdCurrent, newStatus)

    $.ajax({
      url: "/users/editstatus/" + userIdCurrent,
      type: "PUT",
      data: {
        id: userIdCurrent,
        newstatus: newStatus,
      },
      dataType: 'json',
      success: function (data) {
        if (data.status == "success") {
          swal("Sukses", "Status User berhasil diubah!", "success")
            .then(() => {
              location.href = "/users"
            });
        }
        else{
          swal("Pengubahan status gagal!");
        }
      },
      error: function (data) {
          console.log('Error......');
      }
  });
  })

  $('.btn-del').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
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
            url: "/user/"+id,
            type: 'DELETE',
            data: {
              userId: id,
              "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function(data) {
              if (data.success) {
                swal("Sukses", "Data User berhasil dihapus!", "success")
                  .then(() => {
                    location.href = "/users"
                  });
              }
              else{
                swal("Hapus user gagal", data.msg);
              }
            }
          });
        }
      });
  });
</script>
@endif

@endsection
