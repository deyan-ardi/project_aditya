@extends('admin.layout.master')

@section('title', 'Manajemen Pengiriman')

@section('extra_css')
<link rel="stylesheet"
  href="{{ URL::asset('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content-header')
<h1>
  Manajamen Pengiriman
  <small>Halaman manajemen segala pengiriman pesanan</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
  <li><i class="fa fa-truck fa-fw"></i> pengiriman</li>
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
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      {{ session('success') }}
    </div>
    @endif
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">
          Table Data Pesanan Terkirim
        </h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover" id="table_pengiriman1">
          <thead>
            <tr>
              <th>ID Pesanan</th>
              <th>Nama Penerima</th>
              <th>Layanan</th>
              <th>Status Pesanan</th>
              <th>Tanggal Di Kirim</th>
            </tr>
          </thead>
          <tbody>
            <?php $counter = 1; ?>
            @foreach ($data_pengiriman as $item)
            @if($item->status_pesanan == 3)
            <tr>
              <td id="id_{{ $counter }}">
                <a href="">
                  {{ $item->id }}
                </a>
              </td>
              <td>{{ $item->nama_penerima }}</td>
              <td>JNE ({{ $item->layanan }})</td>
              <td>
                <span class="label bg-navy">Telah Di Kirim</span>
              </td>
              <td>{{ $item->tanggal_dikirim }}</td>
            </tr>
            @endif
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
<div class="modal modal-default fade" id="pesanan_selesai">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
      </div>
      {{-- {!! Form::open(['method' => 'PUT', 'id' => 'form_pesanan_selesai']) !!} --}}
      <form action="" method="POST" id="form_pesanan_selesai">
        <div class="modal-footer">
          <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" value="true" class="btn btn-success">Pesanan Selesai</button>
        </div>
      </form>
      {{-- {!! Form::close() !!} --}}
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="batal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Anda Yakin Ingin Dibatalkan ?</h4>
      </div>
      {{-- {!! Form::open(['method' => 'PUT', 'id' => 'form_pesanan_dibatalkan']) !!} --}}
      <form action="" method="POST" id="form_pesanan_dibatalkan">
        <div class="modal-footer">
          <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" value="true" class="btn btn-danger">Pesanan Dibatalkan</button>
        </div>
        {{-- {!! Form::close() !!} --}}
      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('extra_js')

<script src="{{ URL::asset('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(document).ready(function() {
            $('#table_pengiriman1').DataTable({
                'lengthChange': false,
                'length': 10,
                // 'searching': false
            })
            $('#table_pengiriman2').DataTable({
                'lengthChange': false,
                'length': 10,
                // 'searching': false
            })
        })
        $('button.batalkan').click(function() {
            var url = 'http://'+window.location.host
            $('form#form_pesanan_dibatalkan').attr('action', url+'/admin/transaksi/dibatalkan/'+$('button.batalkan').data('pesanan'))
        })
</script>

@endsection