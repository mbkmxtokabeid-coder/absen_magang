<form class="form-horizontal" method="POST" action="{{ route('saveJurusan') }}">
  @csrf
  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="form-group">
      <label for="name" class="control-label col-form-label">Nama Jurusan</label>

      <input type="text" class="form-control" id="name" name="namaJurusan" placeholder="Nama Jurusan">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>