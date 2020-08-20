@extends('admin.layout.master')

@section('title', 'Produk')

@section('extra_css')
<link rel="stylesheet" href="{{ URL::asset('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
">

@endsection

@section('content-header')
<h1>
  Manajemen Produk
  <small>Halaman manajemen produk</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
  <li class="active"><i class="fa fa-cubes fa-fw"></i> Produk</li>
</ol>
@endsection

@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
      @foreach ($errors->all() as $error)
      <li> {{ $error }} </li>
      @endforeach
    </div>
    @elseif (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-ban"></i> Success!</h4>
      {{ session('success') }}
    </div>
    @endif
    <div class="box box-primary collapsed-box">
      <div class="box-header">
        <h3 class="box-title">
          Form Input Produk
        </h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="box-body row">
        {{-- {!! Form::open(['route' => 'tambah_produk', 'files' => true]) !!} --}}
        <form action="{{route('tambah_produk')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="col-sm-6">
            <div class="form-group has-feedback">
              <label for="inp_nama_barang" class="text-black">Nama Produk <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="inp_nama_barang" name="nama_barang">
              <span class="help-block"><small>Masukan nama produk tanpa karakter khusus dan angka</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_id_kategori', 'Pilih Kategori Produk') !!} --}}
              <label for="inp_id_kategori" class="text-black">Pilih Kategori Produk <span
                  class="text-danger">*</span></label>
              <select name="id_kategori" id="inp_id_kategori" class="form-control">
                <option>=== PILIH KATEGORI ===</option>
                @foreach ($data_kategori as $item)
                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                @endforeach
              </select>
              <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_berat_barang', 'Berat Barang @gram') !!}
                        {!! Form::number('berat_barang',  null, ['id' => 'inp_berat_barang', 'class' => 'form-control']) !!} --}}
              <label for="inp_berat_barang" class="text-black">Berat Barang <span class="text-danger">*</span></label>
              <input type="text" id="inp_ berat_barang" class="form-control" name="berat_barang">
              <span class="help-block"><small>Silahkan masukan berat barang dengan satuan gram</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_harga_satuan', 'Harga Satuan') !!}
                        {!! Form::number('harga_satuan',  null, ['id' => 'inp_harga_satuan', 'class' => 'form-control']) !!} --}}
              <label for="inp_harga_satuan" class="text-black">Harga Satuan <span class="text-danger">*</span></label>
              <input type="text" id="inp_harga_satuan" class="form-control" name="harga_satuan">
              <span class="help-block"><small>Silahkan masukan harga satuan produk tanpa karakter khusus dan
                  alphabet</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_stok_barang', 'Stok Barang') !!}
                        {!! Form::number('stok_barang',  null, ['id' => 'inp_stok_barang', 'class' => 'form-control']) !!} --}}
              <label for="inp_stok_barang" class="text-black">Stok Barang <span class="text-danger">*</span></label>
              <input type="text" id="inp_stok_barang" class="form-control" name="stok_barang">
              <span class="help-block"><small>Silahkan masukan stok produk yanpa karakter khusus dan
                  alphabet</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_foto_barang', 'Foto Product') !!}
                        {!! Form::file('foto_barang', ['id' => 'inp_foto_barang', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!} --}}
              <label for="inp_Foto_barang" class="text-black">Foto Barang <span class="text-danger">*</span></label>
              <input type="file" id="inp_Foto_barang" class="form-control" name="foto_barang" accept="image/*">
              <span class="help-block"><small>Silahkan pilih foto product</small></span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group has-feedback">
              <button type="submit" id="simpan" name="simpan" value="true"
                class="btn btn-primary btn-flat pull-right">Simpan Produk</button>
              <button type="reset" class="btn btn-danger btn-flat">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">
          Table Produk
        </h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover" id="table_produk">
          <thead>
            <tr>
              <th>ID Produk</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Tanggal Masuk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $counter = 1; ?>
            @foreach ($data_produk as $item)
            <tr>
              <td id="id_{{ $counter }}">{{ $item->id }}</td>
              <td id="nama_{{ $counter }}">{{ $item->nama_barang  }}</td>
              <td id="kategori_{{ $counter }}">{{ $item->m_tb_kategori->nama_kategori  }}</td>
              <td>
                @if($item->stok_barang > 0)
                <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Tersedia</span>
                @else
                <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tersedia</span>
                @endif
              </td>
              <td id="tanggal_{{ $counter }}">{{ $item->created_at  }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" class="edit_produk" onclick="displayEdit('{{$item->id}}')" data-toggle="modal"
                        data-target="#edit_produk" id="{{ $counter }}">
                        <i class="fa fa-edit fa-fw"></i> Edit
                      </a>
                    </li>
                    <li>
                      <a href="{{route('hapus_produk', ['id' => $item->id])}}" class="hapus_produk" id="{{ $counter }}">
                        <i class="fa fa-trash fa-fw"></i> Hapus
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <?php $counter++; ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('modal')
<div class="modal modal-default fade" id="edit_produk">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Produk</h4>
      </div>
      {{-- {!! Form::open(['id' => 'form_edit_produk', 'method' => 'PUT', 'files' => true]) !!} --}}
      <form method="POST" action="{{route('admin_edit_produk')}}" id="form_edit_produk" enctype="multipart/form-data">
        <div class="modal-body row">
          @csrf
          <input type="hidden" name="id_barang" id="id_barang" value="">
          <div class="col-md-6">
            <div class="form-group has-feedback">
              <label for="inp_edit_nama_barang" class="text-black">Nama Barang <span
                  class="text-danger">*</span></label>
              <input type="text" id="inp_edit_nama_barang" class="form-control" name="nama_barang">
              <span class="help-block"><small>Masukan nama produk tanpa karakter khusus dan angka</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_edit_id_kategori', 'Pilih Kategori Produk') !!} --}}
              <label for="inp_edit_id_kategori" class="text-black">Pilih Kategori Barang <span
                  class="text-danger">*</span></label>
              <select name="id_kategori" id="inp_edit_id_kategori" class="form-control">
                <option>=== PILIH KATEGORI ===</option>
                <?php $counter_kategori = 1; ?>
                @foreach ($data_kategori as $item)
                <option value="{{ $item->id }}" id="kategori_{{ $counter_kategori }}" class="edit_kategori">
                  {{ $item->nama_kategori }}</option>
                <?php $counter_kategori++; ?>
                @endforeach
              </select>
              <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_edit_foto_barang', 'Foto Product') !!}
                            {!! Form::file('foto_barang', ['id' => 'inp_edit_foto_barang', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!} --}}
              <label for="inp_edit_foto_barang" class="text-black">Foto Barang <span
                  class="text-danger">*</span></label>
              <input type="file" id="inp_edit_foto_barang" class="form-control" name="foto_barang" accept="image/*">
              <span class="help-block"><small>Silahkan pilih foto product</small></span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_edit_berat_barang', 'Berat Barang @gram') !!}
                            {!! Form::number('berat_barang',  null, ['id' => 'inp_edit_berat_barang', 'class' => 'form-control']) !!} --}}
              <label for="inp_edit_berat_barang" class="text-black">Berat Barang <span
                  class="text-danger">*</span></label>
              <input type="text" id="inp_edit_berat_barang" class="form-control" name="berat_barang">
              <span class="help-block"><small>Silahkan masukan berat barang dengan satuan gram</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_edit_harga_satuan', 'Harga Satuan') !!}
                            {!! Form::number('harga_satuan',  null, ['id' => 'inp_edit_harga_satuan', 'class' => 'form-control']) !!} --}}
              <label for="inp_edit_harga_barang" class="text-black">Harga Satuan Barang <span
                  class="text-danger">*</span></label>
              <input type="text" id="inp_edit_harga_barang" class="form-control" name="harga_satuan">
              <span class="help-block"><small>Silahkan masukan harga satuan produk tanpa karakter khusus dan
                  alphabet</small></span>
            </div>
            <div class="form-group has-feedback">
              {{-- {!! Form::label('inp_edit_stok_barang', 'Stok Barang') !!}
                            {!! Form::number('stok_barang',  null, ['id' => 'inp_edit_stok_barang', 'class' => 'form-control']) !!} --}}
              <label for="inp_edit_stok_barang" class="text-black">stok Barang <span
                  class="text-danger">*</span></label>
              <input type="text" id="inp_edit_stok_barang" class="form-control" name="stok_barang">
              <span class="help-block"><small>Silahkan masukan stok produk yanpa karakter khusus dan
                  alphabet</small></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" name="simpan" value="true" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /.modal -->
@endsection

@section('extra_js')
<script src="{{ URL::asset('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/component/ckeditor/ckeditor.js') }}"></script>
<script>
  $(document).ready(function() {
      $('#table_produk').DataTable({
          'lengthChange': false,
          'length': 10,
      })
  })
  CKEDITOR.replace('inp_deskripsi_barang')
  CKEDITOR.replace('inp_edit_deskripsi_barang')

  function displayEdit(params) {
    $.get("{{ route('api_admin_get_barang') }}/" + params, function(data, status){
      var id = data.id;
      var nama_barang = data.nama_barang;
      var id_kategori = data.id_kategori;
      var foto_barang = data.foto_barang;
      var berat_barang = data.berat_barang;
      var harga_satuan = data.harga_satuan;
      var stok_barang = data.stok_barang;

      document.getElementById('id_barang').value = id;
      document.getElementById('inp_edit_nama_barang').value = nama_barang;
      document.getElementById('inp_edit_id_kategori').value = id_kategori;
      document.getElementById('inp_edit_berat_barang').value = berat_barang;
      document.getElementById('inp_edit_harga_barang').value = harga_satuan;
      document.getElementById('inp_edit_stok_barang').value = stok_barang;
    });
  }

</script>

@endsection