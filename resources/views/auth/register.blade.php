@extends('pengguna.template.index')

@section('title', 'Daftar')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Daftar</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-12">
        <h2 class="h3 mb-3 text-black text-center">Pendaftaran Akun Baru</h2>
      </div>
      <div class="col-md-8 mx-auto">
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
          <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }}<br>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="p-3 p-lg-5 border row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inp_nama" class="text-black">Nama Lengkap</label>
                <input type="text" name="name" id="inp_nama" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_jenis_kelamin" class="text-black">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="inp_jenis_kelamin" aria-placeholder="Pilih Jenis Kelamin.."
                  class="form-control">
                  <option value="Pria">Pria</option>
                  <option value="Wanita">Wanita</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inp_email" class="text-black">Email</label>
                <input type="email" name="email" id="inp_email" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="inp_password" class="text-black">Password</label>
                <input type="password" name="password" id="inp_password" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_password_confirmation" class="text-black">Ulangi Password</label>
                <input type="password" name="password_confirmation" id="inp_password_confirmation" class="form-control">
              </div>
              <div class="form-group row mt-5">
                <div class="col-lg-12">
                  <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Daftar
                    Sekarang</button>
                </div>
                <div class="col-lg-12 mt-2">
                  <p class="my-0 mx-0">Sudah Punya Akun ? <a href="{{ route('login') }}">Silahkan Login</a></p>
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