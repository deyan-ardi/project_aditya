@extends('pengguna.template.index')
@section('title', 'Profile '.Auth::user()->name)

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if(session()->has('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }}<br>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <h2 class="h3 mb-3 text-black">Detail Akun</h2>
      </div>
      <div class="col-md-5">
        <h2 class="h3 mb-3 text-black">Informasi Alamat Pengiriman</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">Nama Pengguna</span>
          <p>{{ Auth::user()->name }}</p>
          <span class="d-block text-primary h6 text-uppercase">Jenis Kelamin</span>
          <p>{{ Auth::user()->jenis_kelamin }}</p>
          <span class="d-block text-primary h6 text-uppercase">Email</span>
          <p>{{ Auth::user()->email }}</p>
          <span class="d-block text-primary h6 text-uppercase">Tanggal Bergabung</span>
          <p class="mb-0">{{ Auth::user()->created_at }}</p>
        </div>
      </div>
      <div class="col-md-5">
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">Nama Penerima</span>
          <p>{{ Auth::user()->name }}</p>
          <span class="d-block text-primary h6 text-uppercase">Alamat Rumah</span>
          <p>
            @if(Auth::user()->alamat_rumah != NULL)
            {{ Auth::user()->alamat_rumah }}
            @else
            <span class="badge badge-warning">Alamat Belum Tersedia</span>
            @endif
          </p>
          <span class="d-block text-primary h6 text-uppercase">No. Telepon</span>
          <p class="mb-0">
            @if(Auth::user()->no_telp != NULL)
            {{ Auth::user()->no_telp }}
            @else
            <span class="badge badge-warning">No.Telepon Belum Tersedia</span>
            @endif
          </p>
        </div>
      </div>
      <div class="col-md-3">
        <a href="{{route('pengguna_edit_akun')}}" class="btn btn-info btn-block"><i class="icon-edit"></i> Edit Data
          Pribadi</a>
        <hr>
        <a href="{{route('pengguna_reset_akun')}}" class="btn btn-info btn-block"><i class="icon-lock"></i> Ganti
          Password</a>
        <hr>
      </div>
    </div>
  </div>
</div>
@endsection