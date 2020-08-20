@extends('pengguna.template.index')

@section('title', 'Upload Bukti')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <a href="{{ route('pengguna_pemesanan') }}">Pemesanan</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Upload Bukti</strong>
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
        <h2 class="h3 mb-3 text-black text-center">Upload Bukti Pembayaran</h2>
      </div>
      <div class="col-md-5 mx-auto">
        <form action="{{route('pengguna_pembayaran_upload_bukti_post')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="p-3 p-lg-5 border">
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

            @endif
            <div class="form-group">
              <input type="hidden" name="id_pemesanan" value="{{$id_pesanan}}">
              <label for="inp_bukti_pembayaran" class="text-black">Bukti Pembayaran</label>
              <input type="file" name="bukti_pembayaran" id="inp_bukti_pembayaran" class="form-control"
                style="border: 0;" accept="image/*">
              <small class="help-block">Pastikan format foto yang di upload : jpg, jpeg, atau png</small>
            </div>
            <div class="form-group row mt-5">
              <div class="col-lg-12">
                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Upload
                  Bukti</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection