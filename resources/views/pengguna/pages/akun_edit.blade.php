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
        <strong class="text-black">Edit Data Pribadi</strong>
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
        <h2 class="h3 mb-3 text-black">Edit Data Pribadi</h2>
      </div>
      <div class="col-md-8">
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
        <form action="{{route('pengguna_edit_akun_post')}}" method="post">
          @csrf
          <div class="p-3 p-lg-5 border row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inp_nama" class="text-black">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="inp_nama" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_jenis_kelamin" class="text-black">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="inp_jenis_kelamin" class="form-control">
                  <option value="Pria">Pria</option>
                  <option value="Wanita">Wanita</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inp_email" class="text-black">Email</label>
                <input type="email" name="email" id="inp_email" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_no_telepon" class="text-black">No. Telepon</label>
                <input type="text" name="no_telepon" id="inp_no_telepon" class="form-control">
              </div>
              <div class="form-group">
                <label for="inp_alamat" class="text-black">Alamat</label>
                <textarea name="alamat_rumah" class="form-control" id="inp_alamat" rows="3"></textarea>
              </div>
            </div>
            <div class="col-md-12 mt-5">
              <h5>Konfirmasi Password</h5>
              <hr>
              <div class="form-group">
                <label for="inp_password" class="text-black">Password</label>
                <input type="password" name="password" id="inp_password" class="form-control">
              </div>
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