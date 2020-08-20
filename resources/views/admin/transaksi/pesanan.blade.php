@extends('admin.layout.master')

@section('title', 'Manajemen Pesanan')

@section('extra_css')

<link rel="stylesheet"
  href="{{ URL::asset('public/admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection

@section('content-header')
<h1>
  Manajamen Pesanan
  <small>Halaman manajemen segala pesanan</small>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-home"></i> Beranda</a></li>
  <li><i class="fa fa-shopping-cart fa-fw"></i> pesanan</li>
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
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">
          Table Pesanan Yang Sedang Di Proses
        </h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover" id="table_pesanan_di_proses">
          <thead>
            <tr>
              <th>ID Pesanan</th>
              <th>Nama Penerima</th>
              <th>Status Pesanan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="values">
            <?php $counter1 = 1; ?>
            @foreach ($data_pesanan as $item)
            @if($item->status_pesanan <= 1) <tr>
              <td id="id_{{ $counter1 }}">{{ $item->id }}</td>
              <td>{{ $item->nama_penerima  }}</td>
              <td>
                @if($item->dibatalkan == 0)
                <span class="label {{ $stat_label[$item->status_pesanan] }}">
                  {{ $stat_notif[$item->status_pesanan] }}
                </span>
                @else
                <span class="label bg-red">
                  Dibatalkan
                </span>
                @endif
              </td>
              <td>
                @if($item->dibatalkan == 0)
                <?php $carbon = new Carbon\Carbon(); ?>
                <?php //$limit_check = $carbon::parse(explode(' ', $carbon::now())[0])->greaterThanOrEqualTo($carbon::parse($item->batas_pembayaran)) ?>
                {{-- @if($limit_check && !is_null($item->foto_bukti)) --}}
                @if($carbon::parse(explode(' ',
                $carbon::now())[0])->lessThanOrEqualTo($carbon::parse($item->batas_pembayaran)))
                @if($item->status_pesanan == 1)
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" class="proses_pesanan" data-toggle="modal" onclick="change_pesanan('{{$item->id}}')"
                        data-target="#proses_pesanan" id="{{ $counter1 }}">
                        <i class="fa fa-refresh fa-fw"></i> Proses Pesanan
                      </a>
                    </li>
                  </ul>
                </div>
                @else
                <span class="label bg-yellow">Menunggu Pembayaran</span>
                <a href="#" class="batalkan_pesanan" data-toggle="modal" data-target="#batalkan_pesanan"
                  id="{{ $counter1 }}">
                  <span class="label label-danger"><i class="fa fa-ban fa-fw"></i> Batalkan</span>
                </a>
                @endif
                @else
                <span class="label bg-red">Expired</span>
                <a href="#" class="label bg-red hapus_pesanan" data-toggle="modal" data-target="#hapus_pesanan"
                  id="{{ $counter1 }}">
                  <i class="fa fa-trash fa-fw"></i> Hapus
                </a>
                @endif
                @else
                <div class="btn-group">
                  <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" class="batalkan_pesanan" data-toggle="modal" data-target="#batalkan_pesanan"
                        id="{{ $counter1 }}">
                        <i class="fa fa-reply fa-fw"></i> Cabut Status Batal
                      </a>
                    </li>
                    <li>
                      <a href="#" class="hapus_pesanan" data-toggle="modal" data-target="#hapus_pesanan"
                        id="{{ $counter1 }}">
                        <i class="fa fa-trash fa-fw"></i> Hapus pesanan
                      </a>
                    </li>
                  </ul>
                </div>
                @endif
              </td>
              </tr>
              @endif
              <?php $counter1++; ?>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">
          Table Pesanan Yang Siap Di Kirim
        </h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover" id="table_pesanan_siap_kirim">
          <thead>
            <tr>
              <th>ID Pesanan</th>
              <th>Nama Penerima</th>
              <th>Layanan</th>
              <th>Status Pesanan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $counter2 = 1; ?>
            @foreach ($data_pesanan as $item)
            @if($item->status_pesanan == 2)
            <tr>
              <td id="id_{{ $counter2 }}">{{ $item->id }}</td>
              <td>{{ $item->nama_penerima  }}</td>
              <td>JNE ({{ $item->layanan }})</td>
              <td>
                <span class="label {{ $stat_label[$item->status_pesanan] }}">
                  {{ $stat_notif[$item->status_pesanan] }}
                </span>
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="{{route('admin_pemesanan_kirim')}}/{{$item->id}}" class="kirim_pesanan"
                        id="{{ $counter2 }}">
                        <i class="fa fa-truck fa-fw"></i> Kirim Pesanan
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endif
            <?php $counter2++; ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('modal')
<div class="modal modal-default fade" id="proses_pesanan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Proses Pesanan ?</h4>
      </div>
      <form action="{{route('admin_pemesanan_proses')}}" id="form_proses_pesanan" method="post">
        @csrf
        <input type="hidden" name="id_pesanan" id="id_pesanan">
        <div class="modal-footer">
          <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" value="true" class="btn btn-primary"><i class="fa fa-refresh fa-fw"></i>
            Proses pesanan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection

@section('extra_js')

<script src="{{ URL::asset('public/admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}">
<script>
        $(document).ready(function() {
            $('#table_pesanan_di_proses').DataTable({
                'lengthChange': false,
                'length': 10,
            })
            $('#table_pesanan_siap_kirim').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
</script>

<script>
  function change_pesanan(params) {
    document.getElementById('id_pesanan').value = params;
  }
</script>

@endsection