@extends('pengguna.template.index')

@section('title', $produk->nama_barang)

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <a href="{{ route('api_getProduk') }}">Produk</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Detail</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><i class="icon-ban"></i> ERROR!!</strong><br>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @elseif(session()->has('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }} <br>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
      </div>
      <div class="col-md-6">
        <img src="{{$produk->foto_barang}}" class="img-fluid" alt="">
      </div>
      <div class="col-md-6">
        <h2 class="text-black my-3"> {{ $produk->nama_barang }}</h2>
        <table class="table mb-5">
          <tr>
            <td>Berat</td>
            <td>:</td>
            <td>{{ $produk->berat_barang }} gram</td>
          </tr>
          <tr>
            <td>Stok</td>
            <td>:</td>
            <td><b>{{ $produk->stok_barang }} pcs</b></td>
          </tr>
          <tr>
            <td>Status</td>
            <td>:</td>
            <td>
              @if($produk->stok_barang != 0)
              <span class="badge badge-primary"><span class="icon-check"></span> Tersedia</span>
              @else
              <span class="badge badge-danger"><span class="icon-close"></span> Kosong</span>
              @endif
            </td>
          </tr>
          <tr>
            <td>Harga</td>
            <td>:</td>
            <td>
              <strong class="text-primary"> {{ Rupiah::create($produk->harga_satuan) }} </strong>
            </td>
          </tr>
        </table>
        @guest
        <p>
          <a href="{{ route('login') }}" class="buy-now btn btn-sm btn-danger">
            Login Untuk Menambahkan Keranjang
          </a>
        </p>
        @else
        <form action="{{route('pengguna_tambah_keranjang')}}" method="post">
          @csrf
          <input type="hidden" name="id_produk" value="{{$produk->id}}">
          <div class="mb-5">
            <div class="input-group mb-3" style="max-width: 120px;">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
              </div>
              <input type="text" name="jumlah_beli" class="form-control text-center" value="1" placeholder=""
                aria-label="Example text with button addon" aria-describedby="button-addon1">
              <div class="input-group-append">
                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
              </div>
            </div>
          </div>
          <p>
            @if($produk->stok_barang != 0)
            <button type="submit" class="buy-now btn btn-sm btn-primary" name="simpan" value="true">
              Tambah Ke Keranjang
            </button>
            @else
            <button type="button" class="buy-now btn btn-sm btn-primary" disabled>
              Stok Kosong
            </button>
            @endif
          </p>
        </form>
        @endguest
      </div>
    </div>
  </div>
</div>
@endsection