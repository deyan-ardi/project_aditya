@extends('admin.layout.master')

@section('title', 'Beranda')

@section('content-header')
<h1>
  Beranda
  <small>Beranda panel admin my shope</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-home"></i> Beranda</a></li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3>
          {{ Rupiah::create($pendapatan_sekarang) }}
          @if($pendapatan_kemarin != 0)
          @if($pendapatan_sekarang < $pendapatan_kemarin) <small><i class="fa fa-arrow-down text-red"></i> <span
              class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 - 100 }}%</span></small>
            @elseif($pendapatan_sekarang > $pendapatan_kemarin)
            <small><i class="fa fa-arrow-up text-green"></i> <span
                class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 }}%</span></small>
            @else
            -
            @endif
            @endif
        </h3>

        <p>Pendapatan Sekarang</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3>{{ Rupiah::create($pendapatan_kemarin) }}</h3>

        <p>Pendapatan kemarin</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{ $barang }}</h3>

        <p>Barang Tersedia</p>
      </div>
      <div class="icon">
        <i class="fa fa-cubes"></i>
      </div>
      {{-- <a href="{{ route('list_produk') }}" class="small-box-footer">
      More info <i class="fa fa-arrow-circle-right"></i>
      </a> --}}
    </div>
  </div>
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{ $pengguna }}</h3>

        <p>Pengguna Terdaftar</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      {{-- <a href="{{ route('list_produk') }}" class="small-box-footer">
      More info <i class="fa fa-arrow-circle-right"></i>
      </a> --}}
    </div>
  </div>
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{ $admin }}</h3>

        <p>Admin Terdaftar</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      {{-- <a href="{{ route('list_produk') }}" class="small-box-footer">
      More info <i class="fa fa-arrow-circle-right"></i>
      </a> --}}
    </div>
  </div>
</div>

@endsection