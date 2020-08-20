@extends('pengguna.template.index')

@section('title', 'Rubah Data Pribadi')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <a href="{{ route('pengguna_detail_akun') }}">Profile</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Ganti Password</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row" data-aos="fade" data-aos-delay="100">
      <div class="col md-12 mb-5">
        <a href="{{ route('pengguna_detail_akun') }}" class="btn btn-warning">Kembali</a>
      </div>
      <div class="col-md-12">
        <h2 class="h3 mb-3 text-black">Ganti Password</h2>
      </div>
      <div class="col-md-5">
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
        <form action="{{route('pengguna_reset_akun_post')}}" method="post">
          @csrf
          <div class="p-3 p-lg-5 border row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inp_password_lama" class="text-black">Password Lama</label>
                <input type="password" name="password_lama" id="inp_password_lama" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_password_baru" class="text-black">Password Baru</label>
                <input type="password" name="password_baru" id="inp_password_baru" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_password_confirmation" class="text-black">Password Konfirmasi</label>
                <input type="password" name="password_baru_confirmation" id="inp_password_confirmation"
                  class="form-control">
              </div>
            </div>
            <div class="col-md-12 mt-5">
              <div class="form-group row mt-5">
                <div class="col-lg-12">
                  <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Simpan
                    Perubahan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection